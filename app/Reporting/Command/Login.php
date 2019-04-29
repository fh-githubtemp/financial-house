<?php

namespace App\Reporting\Command;

use App\Auth\Guard\TokenGuard;
use Carbon\Carbon;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Login extends Command
{
    protected function execute($params = [])
    {
        $response = $this->client->request('POST', 'merchant/user/login', [
            RequestOptions::JSON => [
                'email'    => Arr::get($params, 'email'),
                'password' => Arr::get($params, 'password'),
            ],
        ]);

        Session::put(TokenGuard::TOKEN_SESSION_KEY, json_encode(['token' => $response['token'], 'expiry' => Carbon::now()->addMinutes(10)->timestamp]));

        return [];
    }

    protected function validateParams($params = [])
    {
        $validator = Validator::make(
            $params,
            [
                'email'    => 'required|email',
                'password' => 'required',
            ]
        );
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}
