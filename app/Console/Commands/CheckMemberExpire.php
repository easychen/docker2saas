<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class CheckMemberExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'droplet:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove expired member\s cloud instance ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($users = User::whereNotNull('do_instance_id')->where('subscription_expire_date', '<', date("Y-m-d"))->get()) {
            foreach ($users as $user) {
                if (strlen($user->do_instance_id) > 0) {
                    remove_do_instance($user->do_instance_id);
                    $user->do_instance_id = null;
                    $user->do_ip = null;
                    $user->do_status = null;
                    $user->save();
                }
            }
        }

        echo count($users) . " user(s) found";
    }
}
