<?php

namespace CustomD\Datazoo\Response;

use CustomD\Datazoo\Response\Contracts\ResponseObject;

class WatchlistResult extends ResponseObject
{
    public $whitelist;
    public $additionalInfoURL;
    public $category;
    public $deathIndex;
    public $gender;
    public $otherNames;
    public $scanId;
    public $yearOfBirth;
}
