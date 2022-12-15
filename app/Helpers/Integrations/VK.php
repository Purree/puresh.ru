<?php

namespace App\Helpers\Integrations;

use App\Exceptions\VKAPIException;
use App\Helpers\Results\FunctionResult;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use JsonException;
use Log;

class VK
{
    protected const STANDARD_EXCEPTION_MESSAGE = 'VK sent incorrect data. Try later.';

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
     * @throws VKAPIException
     */
    protected function throwVKAPIExceptionAndLogErrorFromResponse(array $responseContent): void
    {
        $responseError = $responseContent['error']['error_msg'] ?? __(self::STANDARD_EXCEPTION_MESSAGE);

        Log::error($responseError, [
            'response' => $responseContent,
        ]);
        throw new VKAPIException($responseError);
    }

    /**
     * @throws JsonException
     * @throws ConnectionException
     * @throws VKAPIException
     */
    public function useApiMethod(string $method, array $params = []): array
    {
        $params['v'] = config('vk.API_VERSION');

        try {
            $response = $this->client->get('https://api.vk.com/method/'.$method, [
                'query' => $params,
                'connect_timeout' => 2,
            ]);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $responseContent = $this->jsonDecode($response->getBody());

            $this->throwVKAPIExceptionAndLogErrorFromResponse($responseContent);
        } catch (GuzzleException $exception) {
            Log::error($exception);
            throw new ConnectionException(__(self::STANDARD_EXCEPTION_MESSAGE));
        }

        $responseContent = $this->jsonDecode($response->getBody());

        if (isset($responseContent['error'])) {
            $this->throwVKAPIExceptionAndLogErrorFromResponse($responseContent);
        }

        return $responseContent['response'];
    }

    /**
     * @throws JsonException
     * @throws ConnectionException
     * @throws VKAPIException
     */
    public function useApiMethodFromAuthenticatedUser(string $method, array $params = []): array
    {
        $params['access_token'] = auth()->user()->vk_token;

        return $this->useApiMethod($method, $params);
    }

    /**
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

            if (! isset($responseData['access_token'], $responseData['expires_in'], $responseData['user_id'])) {
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
