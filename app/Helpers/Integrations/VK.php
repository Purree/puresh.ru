<?php

namespace App\Helpers\Integrations;

use App\Exceptions\VKAPIException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use JsonException;
use Log;

class VK
{
    public const STANDARD_EXCEPTION_MESSAGE = 'VK sent incorrect data. Try later.';

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

    protected function getErrorFromApiResponse(array $response): string
    {
        return $response['error']['error_msg'] ?? self::STANDARD_EXCEPTION_MESSAGE;
    }

    /**
     * @throws VKAPIException
     */
    protected function throwVKAPIExceptionAndLogResponse(string $error, array $responseContent): void
    {
        Log::error($error, [
            'response' => $responseContent,
        ]);
        throw new VKAPIException($error);
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

            $this->throwVKAPIExceptionAndLogResponse(
                $this->getErrorFromApiResponse($responseContent),
                $responseContent
            );
        } catch (GuzzleException $exception) {
            Log::error($exception);
            throw new ConnectionException(__(self::STANDARD_EXCEPTION_MESSAGE));
        }

        $responseContent = $this->jsonDecode($response->getBody());

        if (isset($responseContent['error'])) {
            $this->throwVKAPIExceptionAndLogResponse(
                $this->getErrorFromApiResponse($responseContent),
                $responseContent
            );
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
     * @throws ConnectionException|VKAPIException
     */
    public function getUserTokenByCode(string $code): array
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
                $this->throwVKAPIExceptionAndLogResponse(
                    self::STANDARD_EXCEPTION_MESSAGE,
                    $responseData
                );
            }

            return $responseData;
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $responseData = $this->jsonDecode($response->getBody());

            $this->throwVKAPIExceptionAndLogResponse(
                $responseData['error_description'] ?? self::STANDARD_EXCEPTION_MESSAGE,
                $responseData
            );
        } catch (GuzzleException $exception) {
            Log::error($exception);
            throw new ConnectionException(__(self::STANDARD_EXCEPTION_MESSAGE));
        }
    }
}
