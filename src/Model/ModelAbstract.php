<?php

namespace CustomD\Datazoo\Model;

use DateTime;
use Illuminate\Validation\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Translation\ArrayLoader;
use CustomD\Datazoo\Response\AbstractResponse;

abstract class ModelAbstract
{
    /**
     * @var array<string, object>
     */
    protected $services = [];

    public function __construct(array $data = [], array $services = [])
    {
        foreach ($services as $service) {
            $this->addService($service);
        }
        foreach ($data as $field => $value) {
            if (method_exists($this, "set" . ucfirst($field) . "Value")) {
                $this->{'set' . ucfirst($field) . 'Value'}($value);
                continue;
            }
            $this->fields[$field] = $value;
        }
    }

    /**
     * Undocumented function
     *
     * @param string $service
     *
     * @return void
     */
    public function addService(string $service): void
    {
        $class = new $this->serviceMap[$service]();
        $this->services[$service] = $class;
        $this->fields['service'][] = $class->service;
    }

    /**
     * Undocumented function
     *
     * @param string $service
     *
     * @return void
     */
    public function removeService(string $service): void
    {
        $this->services[$service] = false;
    }

        /**
     * @return void
     */
    public function validateData()
    {
        $required = [
            'countryCode'     => ['required','string'],
            'service'         => ['required','array'],
            'clientReference' => ['required','string'],
        ];

        foreach ($this->services as $service) {
            $required = array_merge($required, $service->rules);
        }
        $loader = new ArrayLoader();
        $trans = new Translator($loader, 'en');
        $factory = new Factory($trans);

        $validator = $factory->make(
            $this->fields,
            $required
        );

        $validator->validate();
    }

     /**
     * @param string $value
     *
     * @return static
     */
    public function setClientReferenceValue(string $value)
    {
        $this->fields['clientReference'] = $value;
        return $this;
    }

        /**
     * @param string $value
     *
     * @return static
     */
    public function setFirstNameValue(string $value)
    {
        $this->fields['firstName'] = $value;
        return $this;
    }
    /**
     * @param string $value
     *
     * @return static
     */
    public function setMiddleNameValue(string $value)
    {
        $this->fields['middleName'] = $value;
        return $this;
    }
    /**
     * @param string $value
     *
     * @return static
     */
    public function setLastNameValue(string $value)
    {
        $this->fields['lastName'] = $value;
        return $this;
    }

    /**
     * @param string|\DateTime $value
     *
     * @return static
     */
    public function setDateOfBirthValue($dob)
    {
        if (! $dob instanceof DateTime) {
            $dob = new DateTime($dob);
        }
        $this->fields['dateOfBirth'] = $dob->format("Y-m-d");
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function toRequest()
    {
        $this->validateData();
        return $this->fields;
    }


    /**
     * @param string $body
     *
     * @return AbstractResponse
     */
    public function setResponse(string $body)
    {
        return (new AbstractResponse($body, array_keys($this->services)));
    }
}