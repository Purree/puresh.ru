<?php

namespace App\Helpers\Integrations;

use App\Helpers\Results\FunctionResult;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class VK
{
    public function __construct(protected Client $client)
    {
    }

    /**
     * @throws JsonException
     */
    protected function jsonDecode(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getUserTokenByCode(string $code): FunctionResult
    {
        try {
            $response = $this->client->get(
                'https://oauth.vk.com/access_token',
                [
                    'query' => [
                        'client_id' => config('vk.APP_ID'),
                        'client_secret' => config('vk.APP_SECRET'),
                        'redirect_uri' => route('link-vk-to-account'),
                        'code' => $code,
                    ],
                    'connect_timeout' => 1,
                ]
            );
            $responseData = $this->jsonDecode($response->getBody());

            if (!isset($responseData['access_token'], $responseData['expires_in'], $responseData['user_id'])) {
                return FunctionResult::error(
                    [
                        'error' => 'incorrect data',
                        'error_description' => 'VK sent incorrect data. Try later.',
                    ]
                );
            }

            return FunctionResult::success($responseData);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();

            return FunctionResult::error($this->jsonDecode($response->getBody()));
        } catch (GuzzleException $exception) {
            return FunctionResult::error(
                [
                    'error' => 'connection error',
                    'error_description' => 'Connection error. Try later.',
                ]
            );
        }
    }
}
