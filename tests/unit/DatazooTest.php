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
        $this->assertTrue(! empty($this->datazooConfig['username']));
        $this->assertTrue(! empty($this->datazooConfig['password']));

        $this->assertTrue($this->api->auth());
    }

    // public function testCallDiaBirthNZValidationException()
    // {
    //     $call = new NewZealand([
    //         'firstName'   => 'John',
    //         'lastName'    => 'doe',
    //         'dateOfBirth' => '1978-07-07'
    //     ], ['DiaBirth']);

    //     $this->api->performRequest($call);
    // }

    // public function testCallDiaBirthNZValidationPasses()
    // {
    //     $call = new NewZealand([
    //         'clientReference' => '123456798',
    //         'firstName'       => 'John',
    //         'lastName'        => 'doe',
    //         'dateOfBirth'     => '1978-07-07'
    //     ], ['DiaBirth']);

    //     $res = $this->api->performRequest($call);
    // }
}
