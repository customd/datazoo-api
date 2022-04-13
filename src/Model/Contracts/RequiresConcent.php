<?php

namespace CustomD\Datazoo\Model\Contracts;

trait RequiresConcent
{
    public function addService(string $service): void
    {
        $class = new $this->serviceMap[$service]();
        $this->services[$service] = $class;
        $this->fields['service'][] = $class->service;

        $this->fields['consentObtained'] = array_merge(
            $this->fields['consentObtained'],
            $class->concent
        );
    }
}
