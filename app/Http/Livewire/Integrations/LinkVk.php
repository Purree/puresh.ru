<?php

namespace App\Http\Livewire\Integrations;

use App\Helpers\Integrations\VK;
use Livewire\Component;
use Throwable;

class LinkVk extends Component
{
    public string $code = '';

    public array $errors = [];

    protected vk $vk;

    protected $queryString = ['code'];

    public function mount(VK $vk)
    {
        try {
            $this->vk = $vk;

            $getUserTokenResponse = $vk->getUserTokenByCode($this->code);

            if (! $getUserTokenResponse->success) {
                $this->errors[] = $getUserTokenResponse->errorMessage['error_description'];
            } elseif ($getUserTokenResponse->returnValue['expires_in'] !== 0) {
                $this->errors[] = 'You must allow the token to be stored indefinitely.';
            }
        } catch (Throwable $exception) {
            $this->errors[] = 'Something went wrong. Try again later.';
        }
    }

    public function render()
    {
        return view('livewire.integrations.link-vk');
    }
}
