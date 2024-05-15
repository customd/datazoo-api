<?php

namespace CustomD\Datazoo\Response;

use stdClass;
use CustomD\Datazoo\Response\GlobalWatchlist;

class AbstractResponse
{
    /**
     * @var array $response - json decoded response body
     */
    public $response;

    /**
     * @var array
     */
    protected $services;

    public function __construct(string $response, array $services)
    {
        $this->response = (array) json_decode($response, true, flags: JSON_THROW_ON_ERROR);
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
