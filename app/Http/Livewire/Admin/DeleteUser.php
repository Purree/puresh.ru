<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use App\Actions\Jetstream\DeleteUser as DeleteUserService;

class DeleteUser extends Component
{
    protected array $rules = [
        'user' => 'required'
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

    public function deleteUser()
    {
        $this->validate();

        $test = new DeleteUserService;
        $test->delete($this->user);

        Redirect::back()->with('message','Operation Successful !');
        return redirect($this->page)->with('message',"Пользователь #{$this->user->id} ({$this->user->name}) успешно удалён.");
    }
}
