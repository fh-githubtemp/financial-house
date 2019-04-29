<?php

namespace App\Reporting\Command;

use App\Reporting\Client;
use GuzzleHttp\Exception\ClientException;

abstract class Command
{
    /** @var Client */
    protected $client;

    /**
     * Command constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function run($params)
    {
        try {
            $this->validateParams($params);
            $payload = $this->execute($params);

            return [
                'success' => true,
                'payload' => $payload,
            ];
        } catch (ClientException $e) {
            return [
                'success' => false,
                'error'   => $e->getResponse()->getBody()->getContents(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    abstract protected function execute($params = []);

    abstract protected function validateParams($params = []);
}
