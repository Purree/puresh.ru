<?php

namespace App\Services\Integrations;

use App\Exceptions\InvalidVKTokenException;
use App\Exceptions\VKAPIException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use JsonException;

class VK
{
    public function __construct(public \App\Helpers\Integrations\VK $vk)
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws InvalidVKTokenException
     */
    public function link(string $code): void
    {
        try {
            $getUserTokenResponse = $this->vk->getUserTokenByCode($code);
        } catch (VKAPIException|ConnectionException|JsonException $e) {
            throw new InvalidVKTokenException(\App\Helpers\Integrations\VK::STANDARD_EXCEPTION_MESSAGE);
        }

        if ($getUserTokenResponse['expires_in'] !== 0) {
            throw new InvalidVKTokenException('You must allow the token to be stored indefinitely.');
        }

        auth()->user()->update([
            'vk_token' => $getUserTokenResponse['access_token'],
            'vk_id' => $getUserTokenResponse['user_id'],
        ]);
    }

    public function unlink(): void
    {
        auth()->user()->update([
            'vk_token' => null,
            'vk_id' => null,
        ]);
    }
}
