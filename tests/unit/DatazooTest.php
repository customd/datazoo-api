<?php

declare(strict_types=1);

namespace Tests\Datazoo;

use CustomD\Datazoo\Model\APAC\NewZealand;
use Illuminate\Validation\ValidationException;
use Tests\Datazoo\TestCase;

class DatazooTest extends TestCase
{
    public function testAuth()
    {
        if ($this->hasCredentials()) {
            $this->assertTrue(! empty($this->datazooConfig['username']));
            $this->assertTrue(! empty($this->datazooConfig['password']));
            $this->assertTrue($this->api->auth());
        } else {
            $this->assertTrue($this->fakeCallForAuth()->auth());
        }
    }
}
