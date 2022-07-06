<?php

namespace CustomD\Datazoo\Model;

use CustomD\Datazoo\Response\GlobalWatchlistResponse;

class GlobalWatchlist
{
    /**
     * @var string $service
     */
    public $service = 'Watchlist AML';

    /**
     * @var array $concent
     */
    public $concent = [];

    /**
     * @var array $rules
     */
    public $rules = [
        'dateOfBirth' => ['required','date'],
        'gender'      => ['required'],
    ];

    /**
     * @var array $fields
     */
    public $fields = [
        'firstName',
        'middleName',
        'lastName',
        'dateOfBirth',
        'gender'
    ];

    /**
     * @param class-string $responseObject
     */
    public $responseObject = '\CustomD\Datazoo\Response\GlobalWatchlistResponse';
}
