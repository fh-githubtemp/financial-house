<?php

namespace Tests\Unit\Reporting\Command;

use App\Reporting\Client;
use App\Reporting\Command\GetTransaction;
use GuzzleHttp\RequestOptions;
use Tests\TestCase;

class GetTransactionTest extends TestCase
{
    /** @test */
    public function transactionIdIsMandatory()
    {
        $payload = ['transactionId' => null];

        $command = new GetTransaction($this->getClient());
        $res = $command->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The transaction id field is required.', $res['error']);
    }

    /** @test */
    public function successfullRunWillReturnSuccessTrue()
    {
        $payload = ['transactionId' => '123456'];
        $client = $this->getClient(['request']);
        $client->method('request')
               ->with('POST', 'transaction', [RequestOptions::JSON => $payload]);

        $command = new GetTransaction($client);
        $res = $command->run($payload);

        $this->assertTrue($res['success']);
    }

    protected function getClient($methods = []) : Client
    {
        /** @var Client $client */
        $client = $this->getMockBuilder(Client::class)
                       ->disableOriginalConstructor()
                       ->setMethods($methods)
                       ->getMock();

        return $client;
    }
}
