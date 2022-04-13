<?php

declare(strict_types=1);

namespace Tests\Datazoo;

use CustomD\Datazoo\Model\PepSanctionScreening;
use Tests\Datazoo\TestCase;

class PepSanctionScreeningTest extends TestCase
{
    public function test_call_service()
    {
        $call = new PepSanctionScreening([
            'clientReference' => '123456798',
            'firstName'       => 'Craig',
            'middleName'      => 'Glenham',
            'lastName'        => 'Smith',
            'dateOfBirth'     => '1978-07-12',
            'gender'          => 'Male',
        ], ['GlobalWatchlist']);

        //$res = $this->api->performRequest($call)->getGlobalWatchlistResponse();
        $res = $this->fakeCallFor('PepSanctionScreening')->performRequest($call)->getGlobalWatchlistResponse();

        $json = json_encode($res);

        $this->assertJsonStringEqualsJsonString(file_get_contents(__DIR__ . '/../Responses/PepSanctionScreeningParsed.json'), $json);
    }
}
