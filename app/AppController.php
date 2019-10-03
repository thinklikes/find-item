<?php


namespace App;


use App\Endpoints\Endpoint;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

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
                'delay' => 300
            ],
            'fulfilled' => function (Response $response, $index) use (&$result) {
                $contents = $response->getBody()->getContents();
                $result[get_class($this->endpoints[$index])] = $this->endpoints[$index]->analyze($contents);
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
