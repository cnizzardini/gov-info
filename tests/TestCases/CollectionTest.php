<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Cnizzardini\GovInfo\Api;
use Cnizzardini\GovInfo\Collection;
use Cnizzardini\GovInfo\Requestor\CollectionRequestor;

class CollectionTest extends TestCase
{
    const KEY = 'DEMO_KEY';
    const FIXTURES = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
    
    public function testIndex()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'collections.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objCollection = new Collection($objApi);
        $objResult = $objCollection->index();
        $objItem = reset($objResult->collections);
        
        $this->assertEquals('USCOURTS', $objItem->collectionCode);
    }
    
    public function testItem()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'collections-bills.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objCollection = new Collection($objApi);
        $objRequestor = new CollectionRequestor();
        
        $objResult = $objCollection->item($objRequestor->setStrCollectionCode('BILLS'));
        $objItem = reset($objResult->packages);
        $this->assertEquals('BILLS-115hr2740rfs', $objItem->packageId);
    }
    
    public function testItemWithDates()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'collections-bills.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objCollection = new Collection($objApi);
        $objRequestor = new CollectionRequestor();
        $objRequestor->setStrCollectionCode('BILLS')->setObjStartDate(new \DateTime('2018-01-01 12:00:00'))
            ->setObjEndDate(new \DateTime('2018-02-01 12:00:00'))->setStrDocClass('hr')
            ->setStrPackageId('BILLS-115hr4033rfs')->setStrTitle('Geologic Mapping Act');
        
        $objResult = $objCollection->item($objRequestor);
        
        $objItem = reset($objResult->packages);
        $this->assertEquals('BILLS-115hr4033rfs', $objItem->packageId);
    }    
}