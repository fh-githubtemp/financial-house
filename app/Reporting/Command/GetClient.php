<?php

namespace App\Reporting\Command;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class GetClient extends Command
{
    protected function execute($params = [])
    {
        $options = [
            RequestOptions::JSON => [
                'transactionId' => Arr::get($params, 'transactionId'),
            ],
        ];
        $response = $this->client->request('POST', 'client', $options);

        return $response;
    }

    protected function validateParams($params = [])
    {
        $validator = Validator::make(
            $params,
            [
                'transactionId' => 'required',
            ]
        );
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}
