<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Cnizzardini\GovInfo\Api;
use Cnizzardini\GovInfo\Collection;

class CollectionTest extends TestCase
{
    const KEY = 'DEMO_KEY';
    const FIXTURES = __DIR__ . '/fixtures/';
    
    public function testGet()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'collections.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objCollection = new Collection($objApi);
        $objResult = $objCollection->get();
        $objItem = reset($objResult->collections);
        
        $this->assertEquals('USCOURTS', $objItem->collectionCode);
    }
}