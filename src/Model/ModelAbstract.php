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
    /**
     * @var array<string, mixed>
     */
    protected $fields = [];

    /**
     * @var array <string, class-string>
     */
    protected $serviceMap = [];

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $services
     */
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

    public function addService(string $service): static
    {
        $class = new $this->serviceMap[$service]();
        $this->services[$service] = $class;
        $this->fields['service'][] = $class->service;
        return $this;
    }


    public function removeService(string $service): static
    {
        if (isset($this->services[$service])) {
            unset($this->services[$service]);
        }
        return $this;
    }

    public function validateData(): void
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

    public function setClientReferenceValue(string $value): static
    {
        $this->fields['clientReference'] = $value;
        return $this;
    }

    public function setFirstNameValue(string $value): static
    {
        $this->fields['firstName'] = $value;
        return $this;
    }

    public function setMiddleNameValue(string $value): static
    {
        $this->fields['middleName'] = $value;
        return $this;
    }

    public function setLastNameValue(string $value): static
    {
        $this->fields['lastName'] = $value;
        return $this;
    }

    public function setDateOfBirthValue(string|DateTime $dob): static
    {
        if (! $dob instanceof DateTime) {
            $dob = new DateTime($dob);
        }
        $this->fields['dateOfBirth'] = $dob->format("Y-m-d");
        return $this;
    }

    public function toRequest(): array
    {
        $this->validateData();
        return $this->fields;
    }

    public function setResponse(string $body): AbstractResponse
    {
        return (new AbstractResponse($body, array_keys($this->services)));
    }
}
