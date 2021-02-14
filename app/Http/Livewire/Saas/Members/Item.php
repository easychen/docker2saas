<?php

namespace App\Http\Livewire\Saas\Members;

use Illuminate\Validation\ValidationException;
use App\Models\Plans as SaasPlans;
use App\Models\Settings as SaasSettings;
use App\Models\User;
use Livewire\Component;

class Item extends Component
{
    public $member;
    public $stripe_base;

    public function mount()
    {
        if (substr(env('STRIPE_KEY'), 0, strlen('pk_test_')) == 'pk_test_') {
            $this->stripe_base = 'https://dashboard.stripe.com/test/';
        } else {
            $this->stripe_base = 'https://dashboard.stripe.com/';
        }
    }

    public function refresh_instance($uid, $did)
    {
        $settings = SaasSettings::find(1)->toArray();

        $client = new \DigitalOceanV2\Client();
        $client->authenticate($settings['do_token']);
        $d = $client->droplet();
        $droplet = $d->getById($did);
        if ($droplet && $droplet->id) {
            $public_ip = droplet_ip($droplet);
            User::where(['id'=>$uid])->update([
                'do_status' => $droplet->status,
                'do_ip' => $public_ip,
            ]);

            $user = User::find($uid);
            $this->member = $user->toArray();
        }
    }

    public function remove_instance($uid, $did)
    {
        $settings = SaasSettings::find(1)->toArray();

        $client = new \DigitalOceanV2\Client();
        $client->authenticate($settings['do_token']);
        $ret= $client->droplet()->remove($did);

        User::where('id', $uid)
        ->update([
            'do_instance_id' =>'',
            'do_status' =>'',
            'do_ip' => '',
        ]);

        $user = User::find($uid);
        $this->member = $user->toArray();
    }

    public function restart_instance($uid, $did)
    {
        $settings = SaasSettings::find(1)->toArray();

        $client = new \DigitalOceanV2\Client();
        $client->authenticate($settings['do_token']);
        $ret = $client->droplet()->reboot($did);
    }

    public function create_instance($uid, $price_id)
    {
        // 创建 do instance
        // 先抽取 do 的相关配置
        $plan = SaasPlans::where(['stripe_price_id'=>$price_id])->first();
        if (!$plan) {
            session()->flash('message', 'Bad price id.');
            return false;
        }
        $plan = $plan->toArray();
        if ($user = create_do_instance($plan, $uid)) {
            $this->member = $user->toArray();
        }



        // dd(['uid'=>$uid,'price_id'=>$price_id]);
    }

    public function render()
    {
        return view('livewire.saas.members.item');
    }
}
