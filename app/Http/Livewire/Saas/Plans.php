<?php

namespace App\Http\Livewire\Saas;

use App\Models\Plans as SaasPlans;
use Livewire\Component;

class Plans extends Component
{
    public $plans;
    public $site_url;

    protected $rules = [
        'state.name' => 'required|string',
        'state.stripe_price_id' => 'required|string',
    ];

    public function mount()
    {
        $this->site_url = env('APP_URL');
        $this->load();
    }

    private function load()
    {
        $this->plans = SaasPlans::where(['deleted'=>0])->get()->toArray();
    }

    public function go($route, $id = null)
    {
        redirect()->route($route, $id);
    }

    public function toggle_enable($plan_id, $enabled)
    {
        $enabled = intval($enabled) == 1 ? 1 : 0;
        SaasPlans::where(['id'=>$plan_id])->update(['enabled'=>$enabled]);
        $this->load();
        // dd($ret);
    }

    public function render()
    {
        return view('livewire.saas.plans');
    }
}
