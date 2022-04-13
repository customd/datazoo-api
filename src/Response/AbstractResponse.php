<?php

namespace CustomD\Datazoo\Response;

use CustomD\Datazoo\Response\GlobalWatchlist;

class AbstractResponse
{
    /**
     * @var stdClass $response - json decoded response body
     */
    public $response;

    /**
     * @var array
     */
    protected $services;

    public function __construct(string $response, array $services)
    {
        $this->response = json_decode($response, true);
        foreach ($services as $service) {
            $c = "\\CustomD\\Datazoo\\Response\\$service";
            $this->services[$service] = new $c($this->response);
        }
    }

    public function getGlobalWatchlistResponse()
    {
        return $this->services['GlobalWatchlist'];
    }
}
