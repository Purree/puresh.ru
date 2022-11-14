<?php

namespace App\Http\Livewire\Integrations;

use App\Helpers\Integrations\VK;
use Illuminate\Support\Facades\Log;
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
            } else {
                auth()->user()->update([
                    'vk_token' => $getUserTokenResponse->returnValue['access_token'],
                    'vk_id' => $getUserTokenResponse->returnValue['user_id'],
                ]);
            }
        } catch (Throwable $exception) {
            Log::error($exception);
            $this->errors[] = 'Something went wrong. Try again later.';
        }
    }

    public function render()
    {
        return view('livewire.integrations.link-vk', ['token_validation_errors' => $this->errors]);
    }
}
