<?php

// Github visibility bool set to - "public"

use PHPUnit\Framework\TestCase;
use Elasticsearch\Client; // Import the Elasticsearch Client class
//use Elasticsearch\ClientBuilder;

require_once __DIR__ . '/../src/DataHandler.php'; // Include the DataHandler class

class DataHandlerTest extends Testcase
{
    public function testSearchData()
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('search')
            ->willReturn([
                'hits' => [
                    'hits' => [
                        ['_source' => ['content' => 'test data']]
                    ]
                ]
            ]);

        $dataHandler = new DataHandler();
        $reflection = new ReflectionClass($dataHandler);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($dataHandler, $mockClient);

        $result = $dataHandler->searchData('test_index', 'test query');
        $this->assertCount(1, $result);
        $this->assertEquals('test data', $result[0]['_source']['content']);
    }
};
