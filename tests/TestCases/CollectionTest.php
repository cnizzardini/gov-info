<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GovInfo\Api;
use GovInfo\Collection;
use GovInfo\Requestor\CollectionAbstractRequestor;

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
        $arrResult = $objCollection->index();
        $arrItem = reset($arrResult['collections']);
        
        $this->assertEquals('USCOURTS', $arrItem['collectionCode']);
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
        $objRequestor = new CollectionAbstractRequestor();
        $objRequestor
            ->setStrCollectionCode('BILLS')
            ->setObjStartDate(new \DateTime('2020-01-01'));

        $arrResult = $objCollection->item($objRequestor);
        $arrItem = reset($arrResult['packages']);
        $this->assertEquals('BILLS-115hr2740rfs', $arrItem['packageId']);
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
        $objRequestor = new CollectionAbstractRequestor();
        $objRequestor->setStrCollectionCode('BILLS')->setObjStartDate(new \DateTime('2018-01-01 12:00:00'))
            ->setObjEndDate(new \DateTime('2018-02-01 12:00:00'))->setStrDocClass('hr')
            ->setStrPackageId('BILLS-115hr4033rfs')->setStrTitle('Geologic Mapping Act');
        
        $arrResult = $objCollection->item($objRequestor);
        
        $arrItem = reset($arrResult['packages']);
        $this->assertEquals('BILLS-115hr4033rfs', $arrItem['packageId']);
    }    
}