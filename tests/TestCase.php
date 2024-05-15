<?php

declare(strict_types=1);

namespace Tests\Datazoo;

use GuzzleHttp\Client;
use CustomD\Datazoo\Datazoo;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @var array
     */
    protected $datazooConfig = [];

    /**
     * @var \CustomD\Datazoo\Datazoo
     */
    protected $api;

    protected function setUp(): void
    {
        parent::setUp();
        $file = __DIR__ . '/../config.test.php';

        if (is_file($file)) {
            require $file;
        } else {
            $config = [
                'username' => getenv("DATAZOO_USERNAME") ?: null,
                'password' =>  getenv("DATAZOO_PASSWORD") ?: null,
            ];
        }

        $this->datazooConfig = $config;

        $this->api = new Datazoo($config);
    }


    protected function fakeCallFor(string $call, array $headers = [], $code = 200): Datazoo
    {

        $authResponse = file_get_contents(__DIR__ . '/Responses/auth.json');
        $response = file_get_contents(__DIR__ . '/Responses/' . $call . '.json');

        $mock = new MockHandler([
            new Response(200, [], $authResponse),
            new Response($code, $headers, $response),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        return new Datazoo($this->datazooConfig, $client);
    }

    protected function fakeCallForAuth($code = 200): Datazoo
    {

        $authResponse = file_get_contents(__DIR__ . '/Responses/auth.json');

        $mock = new MockHandler([
            new Response(200, [], $authResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        return new Datazoo($this->datazooConfig, $client);
    }

    protected function hasCredentials(): bool
    {
        return isset($this->datazooConfig['username']) && filled($this->datazooConfig['username']);
    }


}
