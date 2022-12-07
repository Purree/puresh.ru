<?php

namespace App\Http\Livewire\Integrations\VK;

use App\Helpers\Integrations\VK;
use App\Helpers\Results\FunctionResult;
use Livewire\Component;

class UserData extends Component
{
    protected VK $vk;

    public string $name = '';
    public string $surname = '';
    public string $nickname = '';
    public string $maidenName = '';
    public int $userId = 0;
    public string $domain = '';
    public string $photo = '';
    public string $photoMaxSize = '';

    public function boot(VK $vk): void
    {
        $this->vk = $vk;
    }

    protected function getUserData(): FunctionResult
    {
        return $this->vk->useApiMethodFromAuthenticatedUser('users.get', [
            'fields' => 'about, domain, photo_100, maiden_name, nickname, photo_max_orig',
        ]);
    }

    protected function fillUserDataVariables(array $userData): void
    {
        $this->name = $userData['first_name'];
        $this->surname = $userData['last_name'];
        $this->nickname = $userData['nickname'];
        $this->maidenName = $userData['maiden_name'];
        $this->userId = $userData['id'];
        $this->domain = $userData['domain'];
        $this->photo = $userData['photo_100'];
        $this->photoMaxSize = $userData['photo_max_orig'];
    }

    public function render()
    {
        $rawUserData = $this->getUserData();

        if ($rawUserData->success) {
            $this->fillUserDataVariables($rawUserData->returnValue[0]);
        } else {
            $this->addError('apiRequest', $rawUserData->errorMessage['error_description']);
        }

        return view('livewire.integrations.vk.user-data');
    }
}
