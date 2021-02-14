<?php

namespace App\Http\Livewire\Saas\Plans;

use App\Models\Plans as SaasPlans;

use Livewire\Component;

class Delete extends Component
{
    public $state;
    public SaasPlans $plan;

    public function mount()
    {
        $this->plan = SaasPlans::find(request()->plan_id);
        $this->state = $this->plan->toArray();
        $this->state['retype_name'] = "";
    }

    public function delete()
    {
        if ($this->state['retype_name'] != $this->state['name']) {
            //
            session()->flash('message', 'Bad plan name.');
        // dd("bad name");
        } else {
            $this->plan->update(['deleted'=>1]);
            redirect()->route('plans.list');
        }
    }

    public function render()
    {
        return view('livewire.saas.plans.delete');
    }
}
