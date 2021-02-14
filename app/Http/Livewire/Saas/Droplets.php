<?php

namespace App\Http\Livewire\Saas;

use Illuminate\Support\Facades\DB;
use App\Models\Settings as SaasSettings;
use Livewire\Component;

class Droplets extends Component
{
    public $droplets;

    public function mount()
    {
        $settings = SaasSettings::find(1)->first()->toArray();
        if (strlen($settings['do_token']) < 1) {
            return show_error("Set DigtaiOcean Token in settings page first");
        }
        $client = new \DigitalOceanV2\Client();
        $client->authenticate($settings['do_token']);
        $droplets = $client->droplet()->getAll();

        $site_droplets = [];
        foreach ($droplets as $droplet) {
            if (strtolower(substr($droplet->name, 0, strlen('docker2Saas'))) == 'docker2saas') {
                $site_droplets[] = $droplet;
            }
        }

        $this->droplets = $site_droplets;

        $when = "";
        $ids = [];

        foreach ($site_droplets as $droplet) {
            $ids[] = "'". $droplet->id ."'";
            $when = " WHEN `do_instance_id` = '" . $droplet->id . "' THEN '" . $droplet->status . "' ";
        }

        if (count($ids) > 0) {
            // 更新user表中的状态
            $sql = "UPDATE `users` SET `do_status` = CASE $when ELSE `do_status` END WHERE `do_instance_id` IN ( " . join(",", $ids) . " ) ";

            DB::statement($sql);
        }
    }

    public function render()
    {
        return view('livewire.saas.droplets');
    }
}
