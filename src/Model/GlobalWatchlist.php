<?php

namespace CustomD\Datazoo\Model;

use CustomD\Datazoo\Response\GlobalWatchlistResponse;

class GlobalWatchlist
{
    public string $service = 'Watchlist AML';

    public array $concent = [];

    public array $rules = [
        'dateOfBirth' => ['required','date'],
        'gender'      => ['required'],
    ];

    public array $fields = [
        'firstName',
        'middleName',
        'lastName',
        'dateOfBirth',
        'gender'
    ];

    /**
     * @param class-string $responseObject
     */
    public string $responseObject = '\CustomD\Datazoo\Response\GlobalWatchlistResponse';
}
