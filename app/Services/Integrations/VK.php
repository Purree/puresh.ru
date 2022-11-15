<?php

namespace App\Services\Integrations;

use App\Exceptions\InvalidVKTokenException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class VK
{
    public function __construct(public \App\Helpers\Integrations\VK $vk)
    {
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function link(string $code): void
    {
        $getUserTokenResponse = $this->vk->getUserTokenByCode($code);

        if (! $getUserTokenResponse->success) {
            throw new InvalidVKTokenException($getUserTokenResponse->errorMessage['error_description']);
        }

        if ($getUserTokenResponse->returnValue['expires_in'] !== 0) {
            throw new InvalidVKTokenException('You must allow the token to be stored indefinitely.');
        }

        auth()->user()->update([
            'vk_token' => $getUserTokenResponse->returnValue['access_token'],
            'vk_id' => $getUserTokenResponse->returnValue['user_id'],
        ]);
    }
}
