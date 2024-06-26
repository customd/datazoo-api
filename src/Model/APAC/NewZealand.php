<?php

namespace CustomD\Datazoo\Model\APAC;

use DateTime;
use CustomD\Datazoo\Model\ModelAbstract;
use CustomD\Datazoo\Model\APAC\NewZealand\DiaBirth;
use CustomD\Datazoo\Model\Contracts\RequiresConcent;

class NewZealand extends ModelAbstract
{
    use RequiresConcent;

    /**
     * @var array <string, class-string>
     */
    protected $serviceMap = [
        'DiaBirth' => DiaBirth::class
    ];

    /**

     * @var array<string, mixed>
     */
    protected $fields = [
        "countryCode"       =>  "NZ",
        "service"           =>  [],
        "clientReference"   =>  null,
        "firstName"         => null,
        "middleName"        =>  null,
        "lastName"          => null,
        "dateOfBirth"       => null,
        "identityVariables" =>  null,
        "consentObtained"   =>  []
    ];
}
