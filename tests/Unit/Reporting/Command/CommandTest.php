<?php

namespace Tests\Unit\Reporting\Command;

use App\Reporting\Client;
use App\Reporting\Command\GetClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\RequestOptions;
use Tests\TestCase;

class CommandTest extends TestCase
{
    /** @test */
    public function returnSuccessFalseOnException()
    {
        $payload = ['transactionId' => '12345'];
        $exceptionMessage = 'Generic Message';

        $client = $this->getClient(['request']);
        $client->method('request')
               ->with('POST', 'client', [RequestOptions::JSON => $payload])
               ->willThrowException(new \Exception($exceptionMessage));

        $command = new GetClient($client);
        $res = $command->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals($exceptionMessage, $res['error']);
    }

    /** @test */
    public function returnSuccessFalseOnClientException()
    {
        $payload = ['transactionId' => '12345'];
        $exceptionMessage = 'Generic Message';

        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $responseBody = $this->getMockBuilder(Stream::class)
                             ->disableOriginalConstructor()
                             ->setMethods(['getContents'])
                             ->getMock();
        $responseBody->method('getContents')->willReturn($exceptionMessage);

        $response = $this->getMockBuilder(Response::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['getBody'])
                         ->getMock();
        $response->method('getBody')
                 ->willReturn($responseBody);

        $client = $this->getClient(['request']);

        $client->method('request')
               ->with('POST', 'client', [RequestOptions::JSON => $payload])
               ->willThrowException(new ClientException($exceptionMessage, $request, $response));

        $command = new GetClient($client);
        $res = $command->run($payload);
        $this->assertFalse($res['success']);
        $this->assertEquals($exceptionMessage, $res['error']);
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
