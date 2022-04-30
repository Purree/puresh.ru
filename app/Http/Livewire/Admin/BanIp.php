<?php

namespace App\Http\Livewire\Admin;

use App\Models\RestrictedIp;
use Livewire\Component;

class BanIp extends Component
{
    protected array $rules = [
        'ip' => 'required|ip|unique:restricted_ips'
    ];

    public string $ip = "";

    public function render()
    {
        return view('livewire.admin.ban-ip');
    }

    public function ban()
    {
        $this->validate();

        RestrictedIp::banIP($this->ip);

        session()->flash('message', __('IP :ip successfully banned.', ['ip' => $this->ip]));
    }
}
