<?php

namespace Tests\Unit\Reporting;

use App\Auth\Guard\TokenGuard;
use App\Reporting\Client;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /** @test */
    public function isNoTokenInSessionNoAuthHeader()
    {
        $http = $this->getHttp();
        $http->method('request')
             ->with('POST', '/', [])
             ->willReturn($this->getResponse(['success' => true]));

        $client = new Client($http);
        $res = $client->request('POST', '/', []);
        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isTokenInSessionAuthHeader()
    {
        Session::put(TokenGuard::TOKEN_SESSION_KEY, json_encode([
            'token'  => 'TOKEN',
            'expiry' => Carbon::now()->addYear()->timestamp,
        ]));

        $http = $this->getHttp();
        $http->method('request')
             ->with('POST', '/', ['headers' => ['Authorization' => 'TOKEN', 'content-type' => 'application/json']])
             ->willReturn($this->getResponse(['success' => true]));

        $client = new Client($http);
        $res = $client->request('POST', '/', []);
        $this->assertTrue($res['success']);
    }

    /** @test */
    public function ifTokenIsNotValidJsonNoAuthHeader()
    {
        Session::put(TokenGuard::TOKEN_SESSION_KEY, 'Invalid');

        $http = $this->getHttp();
        $http->method('request')
             ->with('POST', '/', [])
             ->willReturn($this->getResponse(['success' => true]));

        $client = new Client($http);
        $res = $client->request('POST', '/', []);
        $this->assertTrue($res['success']);
    }

    /** @test */
    public function ifTokenExpiredNoAuthHeader()
    {
        Session::put(TokenGuard::TOKEN_SESSION_KEY, json_encode([
            'token'  => 'TOKEN',
            'expiry' => Carbon::now()->subYear()->timestamp,
        ]));

        $http = $this->getHttp();
        $http->method('request')
             ->with('POST', '/', [])
             ->willReturn($this->getResponse(['success' => true]));

        $client = new Client($http);
        $res = $client->request('POST', '/', []);
        $this->assertTrue($res['success']);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function ifResponseHasStatusAndNotApprovedThrowException()
    {
        $http = $this->getHttp();
        $http->method('request')
             ->with('POST', '/', [])
             ->willReturn($this->getResponse(['status' => 'DENIED', 'message' => 'error message']));

        $client = new Client($http);
        $res = $client->request('POST', '/', []);
    }

    protected function getResponse($content = [])
    {
        $responseBody = $this->getMockBuilder(Stream::class)
                             ->disableOriginalConstructor()
                             ->setMethods(['getContents'])
                             ->getMock();
        $responseBody->method('getContents')->willReturn(json_encode($content));

        $response = $this->getMockBuilder(Response::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['getBody'])
                         ->getMock();
        $response->method('getBody')
                 ->willReturn($responseBody);

        return $response;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function getHttp() : \GuzzleHttp\Client
    {
        /** @var \GuzzleHttp\Client $http */
        $http = $this->getMockBuilder(\GuzzleHttp\Client::class)
                     ->setMethods(['request'])
                     ->getMock();

        return $http;
    }
}
