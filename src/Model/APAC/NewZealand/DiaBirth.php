<?php

namespace CustomD\Datazoo\Model\APAC\NewZealand;

class DiaBirth
{
    public $service = 'New Zealand DIA Birth';

    /**
     * @var array<string, bool>
     */
    public $concent = [
        "New Zealand DIA Birth" => true
    ];

    /**
     * @var array<string, mixed>
     */
    public $rules = [
        'dateOfBirth' => ['required','date'],
    ];

    /**
     * @var array<string>
     */
    public $fields = [
        'firstName',
        'middleName',
        'lastName',
        'dateOfBirth'
    ];
}
