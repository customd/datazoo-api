<?php

namespace CustomD\Datazoo\Model;

use DateTime;
use CustomD\Datazoo\Model\ModelAbstract;

class PepSanctionScreening extends ModelAbstract
{
    /**
     * @var array <string, class-string>
     */
    protected $serviceMap = [
        'GlobalWatchlist' => GlobalWatchlist::class
    ];

    /**

     * @var array<string, mixed>
     */
    protected $fields = [
        "countryCode"     =>  "All",
        "service"         =>  [
            "Watchlist AML"
        ],
        "clientReference" =>  null,
        "firstName"       => null,
        "middleName"      =>  null,
        "lastName"        => null,
        "gender"          => null,
    ];
}
