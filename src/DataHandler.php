<?php
require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

class DataHandler
{
    private $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function searchData($index, $query)
    {
        $params = [
            'index' => $index,
            'body' => [
                'query' => [
                    'match' => ['content' => $query]
                ]
            ]
        ];

        $response = $this->client->search($params);
        return $response['hits']['hits'];
    }
}
