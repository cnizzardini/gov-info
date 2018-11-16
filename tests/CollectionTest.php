<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Cnizzardini\GovInfo\Api;
use Cnizzardini\GovInfo\Collection;
use Cnizzardini\GovInfo\Requestor\BillCollection;

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
    
    public function testBills()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'collections-bills.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objCollection = new Collection($objApi);
        
        $objResult = $objCollection->bills(new BillCollection());
        $objItem = reset($objResult->packages);
        $this->assertEquals('BILLS-115hr2740rfs', $objItem->packageId);
    }
    
    public function testBillsWithDates()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'collections-bills.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objCollection = new Collection($objApi);
        $objRequestor = new BillCollection();
        $objRequestor->setObjStartDate(new \DateTime('2018-01-01 12:00:00'));
        $objRequestor->setObjEndDate(new \DateTime('2018-02-01 12:00:00'));
        
        $objResult = $objCollection->bills($objRequestor);
        $objItem = reset($objResult->packages);
        $this->assertEquals('BILLS-115hr2740rfs', $objItem->packageId);
    }    
}