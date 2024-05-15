<?php

namespace CustomD\Datazoo;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use CustomD\Datazoo\Model\ModelAbstract;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;

class Datazoo
{
    protected string $apiUrl = 'https://idu.datazoo.com/api/v2';

    /** @var array{username:string,password:string,debug?:bool} */
    protected array $config;

    protected ?string $sessionToken = null;

    protected ClientInterface $client;

    public function __construct(array $config, ?ClientInterface $client = null)
    {
        if (($config['debug'] ?? false) === true) {
            $this->apiUrl = 'https://idu-test.datazoo.com/api/v2';
        }
        $this->config = $config;
        $this->client = $client ?? new Client();
    }

    public function preAuth(): void
    {
        if ($this->sessionToken === null) {
            $this->auth();
        }
    }

    public function auth(): bool
    {
        try {
            $res = $this->client->post(
                $this->apiUrl . '/auth/sign_in',
                [
                    'json' => [
                        'username' => $this->config['username'],
                        "password" => $this->config['password']
                    ]
                ]
            );
            $response = json_decode($res->getBody(), true);
            $this->sessionToken = $response['sessionToken'] ?? null;
            return $this->sessionToken !== null;
        } catch (ClientException $e) {
            throw ValidationException::withMessages(
                [
                    'message' => $e->getMessage()
                ]
            );
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function performRequest(ModelAbstract $service)
    {
        $this->preAuth();
        try {
            $response = $this->client->post(
                $this->apiUrl . '/verify',
                [
                    'json'    => $service->toRequest(),
                    'headers' => [
                        'Content-Type'  => 'application/json',
                        'Authorization' => $this->sessionToken,
                        'Accept'        => 'application/json'
                    ]
                ]
            );

            return $service->setResponse($response->getBody());
        } catch (ClientException $e) {
            throw new \Exception("Failed to call service");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new \Exception("Failed to call service");
        }
    }
}
