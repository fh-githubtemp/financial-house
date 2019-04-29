<?php

namespace Tests\Unit\Reporting\Command;

use App\Reporting\Client;
use App\Reporting\Command\TransactionQuery;
use Tests\TestCase;

class TransactionQueryTest extends TestCase
{
    /** @test */
    public function ifFromDateExistsMustBeValid()
    {
        $payload = [
            'fromDate' => date('d/m/Y'),
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The from date does not match the format Y-m-d.', $res['error']);

        $payload = [
            'fromDate' => date('Y-m-d'),
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function ifToDateExistsMustBeValid()
    {
        $payload = [
            'toDate' => date('d/m/Y'),
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The to date does not match the format Y-m-d.', $res['error']);

        $payload = [
            'toDate' => date('Y-m-d'),
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isStatusExistsMustBeValid()
    {
        $payload = [
            'status' => 'Invalid',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The selected status is invalid.', $res['error']);

        $payload = [
            'status' => 'APPROVED',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isOperationExistsMustBeValid()
    {
        $payload = [
            'operation' => 'Invalid',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The selected operation is invalid.', $res['error']);

        $payload = [
            'operation' => 'REFUND',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isMerchantIdExistsMustBeValid()
    {
        $payload = [
            'merchantId' => 'A',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The merchant id must be an integer.', $res['error']);

        $payload = [
            'merchantId' => 1,
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isAcquirerIdExistsMustBeValid()
    {
        $payload = [
            'acquirerId' => 'A',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The acquirer id must be an integer.', $res['error']);

        $payload = [
            'acquirerId' => 1,
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isPaymentMethodExistsMustBeValid()
    {
        $payload = [
            'paymentMethod' => 'Invalid',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The selected payment method is invalid.', $res['error']);

        $payload = [
            'paymentMethod' => 'CREDITCARD',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isErrorCodeExistsMustBeValid()
    {
        $payload = [
            'errorCode' => 'Invalid',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The selected error code is invalid.', $res['error']);

        $payload = [
            'errorCode' => 'Invalid Transaction',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isFilterFieldExistsMustBeValid()
    {
        $payload = [
            'filterField' => 'Invalid',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The selected filter field is invalid.', $res['error']);

        $payload = [
            'filterField' => 'Transaction UUID',
            'filterValue' => '1234567',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function isFilterFieldExistsFilterValueMustExists()
    {
        $payload = [
            'filterField' => 'Transaction UUID',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The filter value field is required when filter field is present.', $res['error']);

        $payload = [
            'filterField' => 'Transaction UUID',
            'filterValue' => '1234567',
        ];

        $res = (new TransactionQuery($this->getClient()))->run($payload);

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
