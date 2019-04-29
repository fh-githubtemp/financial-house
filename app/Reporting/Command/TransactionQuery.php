<?php

namespace App\Reporting\Command;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionQuery extends Command
{
    protected function execute($params = [])
    {
        $options = [
            RequestOptions::JSON => [
                'fromDate'      => Arr::get($params, 'fromDate'),
                'toDate'        => Arr::get($params, 'toDate'),
                'status'        => Arr::get($params, 'status'),
                'merchantId'    => Arr::get($params, 'merchantId'),
                'acquirerId'    => Arr::get($params, 'acquirerId'),
                'paymentMethod' => Arr::get($params, 'paymentMethod'),
                'errorCode'     => Arr::get($params, 'errorCode'),
                'filterField'   => Arr::get($params, 'filterField'),
                'filterValue'   => Arr::get($params, 'filterValue'),
                'page'          => Arr::get($params, 'page', 1),
            ],
        ];
        $operation = Arr::get($params, 'operation', []);
        if ($operation) {
            if (!is_array($operation)) {
                $operation = [$operation];
            }
            $options[RequestOptions::JSON]['operation'] = $operation;
        }
        $response = $this->client->request('POST', 'transaction/list', $options);

        return $response;
    }

    protected function validateParams($params = [])
    {
        $validator = Validator::make(
            $params,
            [
                'fromDate'      => 'nullable|date_format:Y-m-d',
                'toDate'        => 'nullable|date_format:Y-m-d',
                'status'        => [
                    'nullable',
                    Rule::in(['APPROVED', 'WAITING', 'DECLINED', 'ERROR']),
                ],
                'operation'     => [
                    'nullable',
                    Rule::in(['DIRECT', 'REFUND', '3D', '3DAUTH', 'STORED']),
                ],
                'merchantId'    => 'nullable|integer',
                'acquirerId'    => 'nullable|integer',
                'paymentMethod' => [
                    'nullable',
                    Rule::in(['CREDITCARD', 'CUP', 'IDEAL', 'GIROPAY', 'MISTERCASH', 'STORED', 'PAYTOCARD', 'CEPBANK', 'CITADEL']),
                ],
                'errorCode'     => [
                    'nullable',
                    Rule::in(['Do not honor', 'Invalid Transaction', 'Invalid Card', 'Not sufficient funds', 'Incorrect PIN', 'Invalid country association', 'Currency not allowed', '3-D Secure Transport Error', 'Transaction not permitted to cardholder']),
                ],
                'filterField'   => [
                    'nullable',
                    Rule::in(['Transaction UUID', 'Customer Email', 'Reference No', 'Custom Data', 'Card PAN']),
                ],
                'filterValue'   => 'required_with:filterField',
            ]
        );
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}
