<?php


namespace App;


use App\Endpoints\Endpoint;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;

class AppController
{
    /**
     * @var array
     */
    protected $searchTexts = [];
    /**
     * @var array | Endpoint[]
     */
    protected $endpoints = [];
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchItems(string $searchText): array
    {
        $client = new Client();

        $requests = function () use ($searchText) {

            foreach ($this->endpoints as $endpoint) {
                yield $endpoint->generateRequest($searchText);
            }
        };

        $result = [];

        $pool = new Pool($client, $requests(), [
            'concurrency' => 5,
            'options' => [
                'delay' => 500
            ],
            'fulfilled' => function (Response $response, $index) use (&$result) {
                $contents = $response->getBody()->getContents();
                $result[$this->endpoints[$index]::NAME] = $this->endpoints[$index]->analyze($contents);
            },
            'rejected' => function ($reason, $index) {
                var_dump($reason->getFile());
                var_dump($reason->getLine());
                var_dump($reason->getMessage());
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        return $result;
    }

    /**
     * @param string $endpointClass
     */
    public function addEndpoint(Endpoint $endpoint)
    {
        $this->endpoints[] = $endpoint;
    }
}
