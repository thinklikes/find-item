<?php


namespace App\Endpoints;


use GuzzleHttp\Psr7\Request;

interface Endpoint
{
    public function generateRequest(string $searchText): Request;

    public function analyze(string $html): array;
}
