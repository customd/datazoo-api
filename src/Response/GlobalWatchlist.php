<?php

namespace CustomD\Datazoo\Response;

use CustomD\Datazoo\Response\Contracts\ResponseObject;

class GlobalWatchlist extends ResponseObject
{
    public $status;
    public $sourceStatus;
    public $errorMessage;
    public $identityVerified;
    public $safeHarbourScore;
    public $nameMatchScore;
    public $addressMatchScore;
    public $verifications;
    public $returnedData;

    public function __construct($response)
    {
        parent::__construct($response['serviceResponses']['Watchlist AML']);
    }

    public function setReturnedDataAttribute($value)
    {
        $this->returnedData = [
            'watchListResults' => (new WatchlistResultsCollection($value['watchlistResults']))->mapInto(WatchlistResult::class)
        ];
    }
}
