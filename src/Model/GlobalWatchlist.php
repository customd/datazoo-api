<?php

namespace CustomD\Datazoo\Model;

use CustomD\Datazoo\Response\GlobalWatchlistResponse;

class GlobalWatchlist
{
    /**
     * @var string
     */
    public $service = 'Watchlist AML';

    /**
     * @var array<string, bool>
     */
    public $concent = [];

    /**
     * @var array<string, mixed>
     */
    public $rules = [
        'dateOfBirth' => ['required','date'],
        'gender'      => ['required'],
    ];

    /**
     * @var array<string>
     */
    public $fields = [
        'firstName',
        'middleName',
        'lastName',
        'dateOfBirth',
        'gender'
    ];

    public $responseObject = '\CustomD\Datazoo\Response\GlobalWatchlistResponse';
}
