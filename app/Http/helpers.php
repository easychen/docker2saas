<?php
use App\Models\Settings as SaasSettings;
use App\Models\User;

function remove_do_instance($did)
{
    $settings = SaasSettings::find(1)->toArray();

    $client = new \DigitalOceanV2\Client();
    $client->authenticate($settings['do_token']);
    $client->droplet()->remove($did);
}

function refresh_do_instance($uid, $did)
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
    }
    return User::find($uid)->first();
}

function show_expire_date($str)
{
    if (strtotime($str . ' 23:59:59') >= time()) {
        return $str;
    } else {
        return false;
    }
}


function create_do_instance($plan, $uid)
{
    $settings = SaasSettings::find(1)->toArray();

    $client = new \DigitalOceanV2\Client();
    $client->authenticate($settings['do_token']);

    $user_data = blade_to_view($plan['do_user_data'], ['user'=>User::find($uid),'plan'=>$plan]);

    $created = $client->droplet()->create('Docker2Saas-'.$plan['id'].'-'.$uid, $plan['do_region'], $plan['do_size'], $plan['do_image'], false, false, false, [$settings['do_sshkey_id']], $user_data??"");

    // User
    if ($created && $created->id) {
        // 更新用户的do id
        $user = User::where(['id'=>$uid])->first();
        $user->do_instance_id = $created->id;
        $user->save();

        return $user;
    }
}

function show_error($message)
{
    session()->flash('message', $message);
    return redirect()->route('notice');
}

function droplet_ip($droplet)
{
    $public_ip = '';
    if ($networks = $droplet->networks) {
        foreach ($networks as $network) {
            if ($network->type == 'public') {
                $public_ip = $network->ipAddress;
            }
        }
    }
    return $public_ip;
}

function blade_to_view($value, $args)
{
    $generated = \Blade::compileString($value);

    ob_start() and extract($args, EXTR_SKIP);

    try {
        eval('?>'.$generated);
    } catch (\Exception $e) {
        ob_get_clean();
        throw $e;
    }

    $content = ob_get_clean();

    return $content;
}
