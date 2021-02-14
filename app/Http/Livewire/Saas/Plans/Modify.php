<?php

namespace App\Http\Livewire\Saas\Plans;

use Illuminate\Support\Facades\Route;
use App\Models\Plans as SaasPlans;
use Livewire\Component;

class Modify extends Component
{
    public $state;
    public SaasPlans $plan;

    protected $rules = [
        'state.name' => 'required|string',
        'state.stripe_price_id' => 'required|string',
    ];

    public function mount()
    {
        // dd(request()->plan_id);
        $this->plan = SaasPlans::find(request()->plan_id);
        $this->state = $this->plan->toArray();
    }

    public function save()
    {
        $this->validate();
        $this->plan->update($this->state);
        $this->emit('saved');
        redirect()->route('plans.list');
    }

    public function render()
    {
        return view('livewire.saas.plans.modify');
    }
}
