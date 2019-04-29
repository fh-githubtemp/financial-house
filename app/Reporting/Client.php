<?php

namespace App\Reporting;

use App\Auth\Guard\TokenGuard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Client
{
    /** @var \GuzzleHttp\Client */
    protected $http;

    /**
     * Client constructor.
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->http = $client;
    }

    public function request($method, $url, $options)
    {
        if ($this->getAccessToken()) {
            $options['headers']['Authorization'] = $this->getAccessToken();
            $options['headers']['content-type'] = 'application/json';
        }
        $res = $this->http->request($method, $url, $options);
        $response = json_decode($res->getBody()->getContents(), true);

        if (isset($response['status']) && $response['status'] !== 'APPROVED') {
            throw new \Exception($response['message']);
        }

        return $response;
    }

    private function getAccessToken()
    {
        $token = Session::get(TokenGuard::TOKEN_SESSION_KEY);
        if (!$token) {
            return false;
        }
        $token = json_decode($token, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Session::remove(TokenGuard::TOKEN_SESSION_KEY);

            return false;
        }
        if (Carbon::createFromTimestamp($token['expiry'])->isPast()) {
            Session::remove(TokenGuard::TOKEN_SESSION_KEY);

            return false;
        }

        return $token['token'];
    }
}
