<?php

namespace Tests\Unit\Reporting\Command;

use App\Reporting\Client;
use App\Reporting\Command\Login;
use GuzzleHttp\RequestOptions;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function successfulRunWillReturnSuccessTrue()
    {
        $payload = ['email' => 'test@example.com', 'password' => 'password'];

        $client = $this->getClient(['request']);
        $client->method('request')
               ->with('POST', 'merchant/user/login', [RequestOptions::JSON => $payload])
               ->willReturn(true);

        $command = new Login($client);
        $res = $command->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function emailIsMandatory()
    {
        $command = new Login($this->getClient());
        $res = $command->run(['password' => 'password']);

        $this->assertFalse($res['success']);
        $this->assertEquals('The email field is required.', $res['error']);
    }

    /** @test */
    public function passwordIsMandatory()
    {
        $command = new Login($this->getClient());
        $res = $command->run(['email' => 'test@example.com']);

        $this->assertFalse($res['success']);
        $this->assertEquals('The password field is required.', $res['error']);
    }

    /** @test */
    public function emailMustBeValidEmail()
    {
        $command = new Login($this->getClient());
        $res = $command->run(['email' => 'test']);

        $this->assertFalse($res['success']);
        $this->assertEquals('The email must be a valid email address.', $res['error']);
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
