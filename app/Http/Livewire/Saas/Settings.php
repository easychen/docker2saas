<?php

namespace App\Http\Livewire\Saas;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings as SaasSettings;
use Livewire\Component;

class Settings extends Component
{
    public $state;
    public $old;

    protected $rules = [
        'state.domain' => 'required|string|min:3',
        'state.name' => 'required|string'
    ];

    public function mount()
    {
        $settings = SaasSettings::find(1) ? SaasSettings::find(1)->toArray():[
            'do_token' => null,
            'do_sshkey_pub' => null,
            'do_sshkey_id' => null
        ];
        $this->state = $settings;
        $this->old = $settings;
    }

    public function render()
    {
        return view('livewire.saas.settings');
    }

    public function save()
    {
        if (strlen($this->state['do_token']) > 0 && strlen($this->state['do_sshkey_pub']) > 0) {
            if (($this->state['do_token'] != $this->old['do_token']) || ($this->state['do_sshkey_pub'] != $this->old['do_sshkey_pub'])) {
                // 检查do的token是否正确
                $client = new \DigitalOceanV2\Client();
                $client->authenticate($this->state['do_token']);

                try {
                    //

                    if ($createdKey = $client->key()->create('D2SKEYU'.Auth::id().'T'.uniqid(), $this->state['do_sshkey_pub'])) {
                        $this->state['do_sshkey_id'] = $createdKey->fingerprint;
                    }
                } catch (\Throwable $e) {
                    // 422 是 key 已经存在，不需要再创建
                    if ($e->getCode() != 422) {
                        throw ValidationException::withMessages(['state.do_token'=>'Add ssh key fail, check the token. ','state.do_sshkey_pub'=>$e->getMessage()]);
                    } else {
                        // 读取全部key，获得fingerprint
                        $keys = $client->key()->getAll();
                        foreach ($keys as $key) {
                            if (trim($key->publicKey) == $this->state['do_sshkey_pub']) {
                                $this->state['do_sshkey_id'] = $key->fingerprint;
                            }
                        }
                    }
                }
            }
        }

        $this->validate();
        // $errors = $this->getErrorBag();
        // dd($errors);


        SaasSettings::updateOrCreate(['id'=>1], $this->state);
        $this->emit('saved');
    }
}
