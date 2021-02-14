<?php

namespace App\Http\Livewire\Saas\Subscription;

use App\Models\Plans;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Mine extends Component
{
    public $uid = false;
    public $did = false;
    public $plan;
    public $sub;
    public $user;

    public function go()
    {
        $url = request()->user()->billingPortalUrl(route('subscribe.mine'));
        redirect($url);
    }

    public function refresh()
    {
        if ($this->uid && $this->did) {
            refresh_do_instance($this->uid, $this->did);
        }
    }

    public function mount()
    {
        $user = Auth::user();
        if ($user->stripe_scription_id) {
            $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
            $subscription  = $stripe->subscriptions->retrieve(
                $user->stripe_scription_id,
                []
            );

            if ($subscription) {
                $sub = $subscription->toArray();
                $plan = Plans::where(['stripe_price_id'=>$sub['plan']['id']])->first()->toArray();
                $this->uid = $user->id;
                $this->did = $user->do_instance_id;
            } else {
                $sub = false;
                $plan = false;
            }
        } else {
            $sub = false;
            $plan = false;
        }

        $this->sub = $sub;
        $this->plan = $plan;
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.saas.subscription.mine');
    }
}
