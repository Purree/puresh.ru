<?php

namespace App\Http\Livewire\Admin;

use App\Models\RestrictedIp;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;

class DeleteIp extends Component
{
    protected array $rules = [
        'ip' => 'required'
    ];

    public object $ip;

    public $page;

    public function mount($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.admin.delete-ip');
    }

    public function deleteIP(): Redirector|Application|RedirectResponse
    {
        $this->validate();

        $this->ip->unban();

        return redirect($this->page)
            ->with('message', __(
                "Ip :ip deleted successfully.",
                ['ip' => $this->ip->ip]
            ));
    }
}
