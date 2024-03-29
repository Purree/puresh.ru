<?php

namespace App\Http\Livewire\Admin;

use App\Actions\Jetstream\DeleteUser as DeleteUserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;

class DeleteUser extends Component
{
    protected array $rules = [
        'user' => 'required',
    ];

    public object $user;

    public $page;

    public function mount($page)
    {
        $this->page = $page;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.admin.delete-user');
    }

    public function deleteUser(): Redirector|Application|RedirectResponse
    {
        $this->validate();

        $deleteUserService = new DeleteUserService();
        $deleteUserService->delete($this->user);

        return redirect($this->page)
            ->with('message', __(
                'User #:id (:name) deleted successfully.',
                ['id' => $this->user->id, 'name' => $this->user->name]
            ));
    }
}
