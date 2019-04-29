<?php

namespace Tests\Unit\Reporting\Command;

use App\Reporting\Client;
use App\Reporting\Command\TransactionReport;
use Tests\TestCase;

class TransactionReportTest extends TestCase
{
    /** @test */
    public function fromDateIsMandatory()
    {
        $payload = [];

        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The from date field is required.', $res['error']);
    }

    /** @test */
    public function fromDateFormatIsYYYYMMDD()
    {
        $payload = [
            'fromDate' => date('d/M/Y'),
            'toDate'   => date('Y-m-d'),
        ];

        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The from date does not match the format Y-m-d.', $res['error']);

        $payload = [
            'fromDate' => date('Y-m-d'),
            'toDate'   => date('Y-m-d'),
        ];

        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function toDateIsMandatory()
    {
        $payload = [
            'fromDate' => date('Y-m-d'),
        ];

        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The to date field is required.', $res['error']);
    }

    /** @test */
    public function toDateFormatIsYYYYMMDD()
    {
        $payload = [
            'fromDate' => date('Y-m-d'),
            'toDate'   => date('d/m/Y'),
        ];

        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The to date does not match the format Y-m-d.', $res['error']);

        $payload = [
            'fromDate' => date('Y-m-d'),
            'toDate'   => date('Y-m-d'),
        ];
        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function ifMerchantIdExistsMustBeInteger()
    {
        $payload = [
            'fromDate' => date('Y-m-d'),
            'toDate'   => date('Y-m-d'),
            'merchant' => 'A',
        ];

        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The merchant must be an integer.', $res['error']);

        $payload = [
            'fromDate' => date('Y-m-d'),
            'toDate'   => date('Y-m-d'),
            'merchant' => 1,
        ];

        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertTrue($res['success']);
    }

    /** @test */
    public function ifAcquirerIdExistsMustBeInteger()
    {
        $payload = [
            'fromDate' => date('Y-m-d'),
            'toDate'   => date('Y-m-d'),
            'acquirer' => 'A',
        ];

        $res = (new TransactionReport($this->getClient()))->run($payload);

        $this->assertFalse($res['success']);
        $this->assertEquals('The acquirer must be an integer.', $res['error']);

        $payload = [
            'fromDate' => date('Y-m-d'),
            'toDate'   => date('Y-m-d'),
            'acquirer' => 1,
        ];

        $res = (new TransactionReport($this->getClient()))->run($payload);

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
