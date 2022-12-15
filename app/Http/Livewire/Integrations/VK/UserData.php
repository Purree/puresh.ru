<?php

namespace App\Http\Livewire\Integrations\VK;

use App\Exceptions\VKAPIException;
use App\Helpers\Integrations\VK;
use Illuminate\Http\Client\ConnectionException;
use JsonException;
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

    /**
     * @throws VKAPIException
     * @throws ConnectionException
     * @throws JsonException
     */
    protected function getUserData(): array
    {
        return $this->vk->useApiMethodFromAuthenticatedUser('users.get', [
            'fields' => 'about, domain, photo_100, maiden_name, nickname, photo_max_orig',
        ])[0];
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
        try {
            $userData = $this->getUserData();

            $this->fillUserDataVariables($userData);
        } catch (VKAPIException|JsonException|ConnectionException $e) {
            $this->addError('apiRequest', $e->getMessage());
        }

        return view('livewire.integrations.vk.user-data');
    }
}
