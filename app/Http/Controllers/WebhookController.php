<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use App\Models\User;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Http\Request;

class WebhookController extends CashierController
{
    public function __construct()
    {
        parent::__construct();
    }
    //
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        $data = $payload['data']['object'];

        $sub_id = $data["id"];
        $customer_id = $data["customer"];

        if ($user = User::where(['stripe_id'=>$customer_id,'stripe_scription_id'=>$sub_id])->first()) {

            // remove do instance
            // do this in cronjob
            // if (strlen($user->do_instance_id) > 0) {
            //     remove_do_instance($user->do_instance_id);
            // }
            // $user->do_instance_id = null;
            // $user->do_ip = null;
            //$user->do_status = null;

            // update subscription and instance info in user table
            $user->stripe_scription_id = null;
            $user->stripe_price_id = null;


            $user->save();
        }

        return $this->successMethod();
    }

    protected function handleCustomerSubscriptionCreated(array $payload)
    {
        return $this->successMethod();
    }

    protected function handleInvoiceFinalized(array $payload)
    {
        file_put_contents('log.final.json', json_encode($payload));
        return $this->successMethod();
    }

    protected function handleInvoicePaid(array $payload)
    {
        $data = $payload['data']['object'];
        // 确认支付信息
        if ($data['paid'] == true) {
            $price = $data['lines']['data'][0]['price'];

            $recurring_info = $price['recurring'];

            $date_to_append = " +".$recurring_info['interval_count'] . $recurring_info['interval'];

            // 获得支付用户
            if ($user = User::where(['stripe_id'=>$data['customer']])->first()) {
                //
                $start_time = strtotime($user->subscription_expire_date) > time() ? $user->subscription_expire_date : date("Y-m-d");

                $new_time = strtotime($start_time .$date_to_append)+60*60*48; // 1 day as gift

                $new_date = date("Y-m-d", $new_time);
                $user->subscription_expire_date = $new_date;
                $user->save();

                if (strlen($user->do_instance_id) < 1) {
                    // 当前用户没有 do instance
                    $plan = Plans::where(['stripe_price_id'=>$price['id']])->first()->toArray();
                    create_do_instance($plan, $user->id);
                }
            }
        }


        return $this->successMethod();
    }

    protected function handleInvoiceCreated(array $payload)
    {
        /*
         * https://stripe.com/docs/billing/subscriptions/webhooks#understand
         * To summarize: If Stripe fails to receive a successful response to invoice.created, then finalizing all invoices with automatic collection will be delayed for up to 72 hours. Responding properly to invoice.created includes handling all webhook endpoints configured for your account, along with the webhook endpoints of any platforms to which you’ve connected. Updating a subscription in a way that synchronously attempts payment (on the initial invoice, and on some kinds of updates) does not cause this webhook wait.
        */
        return $this->successMethod();
    }
}
