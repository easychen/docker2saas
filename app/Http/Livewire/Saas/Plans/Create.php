<?php

namespace App\Http\Livewire\Saas\Plans;

use App\Models\Plans as SaasPlans;
use Livewire\Component;

class Create extends Component
{
    public $state;

    protected $rules = [
        'state.name' => 'required|string',
        'state.stripe_price_id' => 'required|string',
    ];

    public function save()
    {
        $this->validate();
        SaasPlans::create($this->state);
        $this->emit('saved');
        redirect()->route('plans.list');
    }



    public function render()
    {
        return view('livewire.saas.plans.create');
    }
}
