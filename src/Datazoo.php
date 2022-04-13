<?php

namespace CustomD\Datazoo;

use GuzzleHttp\Client;
use CustomD\Datazoo\Model\ModelAbstract;
use Illuminate\Validation\ValidationException;

class Datazoo
{
    /**
     * @var string
     */
    protected $apiUrl = 'https://idu.datazoo.com/api/v2';

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ?string
     */
    protected $sessionToken = null;

    /**
     *
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @param array $config
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct($config, $client = null)
    {
        if ($config['debug'] ?? false === true) {
            $this->apiUrl = 'https://idu-test.datazoo.com/api/v2';
        }
        $this->config = $config;

        $this->client = $client ?? new Client();
    }

    /**
     * @return void
     */
    public function preAuth()
    {
        if ($this->sessionToken === null) {
            $this->auth();
        }
    }

    public function auth(): bool
    {
        try {
            $res = $this->client->post($this->apiUrl . '/auth/sign_in', [
                'json' => [
                    'username' => $this->config['username'],
                    "password" => $this->config['password']
                ]
            ]);
            $response = json_decode($res->getBody(), true);
            $this->sessionToken = $response['sessionToken'] ?? null;
            return $this->sessionToken !== null;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     *
     * @param \CustomD\Datazoo\Model\ModelAbstract $service
     *
     * @return \CustomD\Datazoo\Response\AbstractResponse
     */
    public function performRequest(ModelAbstract $service)
    {
        $this->preAuth();
        try {
            $response = $this->client->post($this->apiUrl . '/verify', [
                'json'    => $service->toRequest(),
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => $this->sessionToken,
                    'Accept'        => 'application/json'
                   // 'UserName'      => $this->config['username']
                ]
            ]);

            return $service->setResponse($response->getBody());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            dd($e);
            throw new \Exception("Failed to call service");
        } catch (ValidationException $e) {
            dd($e);
            throw $e;
        } catch (\Throwable $e) {
            dd($e);
            throw new \Exception("Failed to call service");
        }
    }
}
