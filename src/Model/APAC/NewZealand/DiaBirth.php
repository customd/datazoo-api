<?php

namespace CustomD\Datazoo\Model\APAC\NewZealand;

class DiaBirth
{
    public string $service = 'New Zealand DIA Birth';

    /**
     * @var array<string, bool>
     */
    public array $concent = [
        "New Zealand DIA Birth" => true
    ];

    /**
     * @var array<string, mixed>
     */
    public array $rules = [
        'dateOfBirth' => ['required','date'],
    ];

    /**
     * @var array<string>
     */
    public array $fields = [
        'firstName',
        'middleName',
        'lastName',
        'dateOfBirth'
    ];
}
