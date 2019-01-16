<?php

namespace App\Services;


use GuzzleHttp\Client;

class BeerApi
{
    const API_URL = 'http://ontariobeerapi.ca/';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    private function sendGetRequest(string $endpoint, int $successCode)
    {
        $responseStream = $this->client->request('GET', BeerApi::API_URL . $endpoint);

        if ($responseStream->getStatusCode() == $successCode) {
            $body = $responseStream->getBody()->getContents();
            if($body == '') {
                return null;
            }

            return json_decode($body, true);
        } else {
            throw new \Exception($responseStream->getStatusCode());
        }

    }

    public function getBeers()
    {
        return $this->sendGetRequest('beers', 200);
    }
}


