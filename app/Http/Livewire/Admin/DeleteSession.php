<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;

class DeleteSession extends Component
{
    protected array $rules = [
        'session' => 'required',
    ];

    public object $session;

    public $page;

    public function mount($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.admin.delete-session');
    }

    public function deleteSession(): Redirector|Application|RedirectResponse
    {
        $this->validate();

        $this->session->delete();
        if ($this->session->user) {
            $this->session->user->regenerateRememberToken();
        }

        return redirect($this->page)
            ->with('message', __('Session #:id deleted successfully.', ['id' => $this->session->id]));
    }
}
