<?php

namespace App\Reporting\Command;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class TransactionReport extends Command
{
    protected function execute($params = [])
    {
        $options = [
            RequestOptions::JSON => [
                'fromDate' => Arr::get($params, 'fromDate'),
                'toDate'   => Arr::get($params, 'toDate'),
                'merchant' => Arr::get($params, 'merchant'),
                'acquirer' => Arr::get($params, 'acquirer'),
            ],
        ];
        $response = $this->client->request('POST', 'transactions/report', $options);

        return $response;
    }

    protected function validateParams($params = [])
    {
        $validator = Validator::make(
            $params,
            [
                'fromDate' => 'required|date_format:Y-m-d',
                'toDate'   => 'required|date_format:Y-m-d',
                'merchant' => 'nullable|integer',
                'acquirer' => 'nullable|integer',
            ]
        );
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}
