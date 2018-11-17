<?php
use PHPUnit\Framework\TestCase;
use Cnizzardini\GovInfo\Requestor\CollectionRequestor;

class CollectionRequestorTest extends TestCase
{
    const COLLECTION_CODE = 'BILLS';
    const DOC_CLASS = 'HR';
    const TITLE = 'Hello world';
    const PACKAGE_ID = 'ABC';
    
    public function testObject()
    {
        $objStartDate = new \DateTime('2018-01-01');
        $objEndDate = new \DateTime('2019-01-01');
        
        $objRequestor = new CollectionRequestor();
        $objRequestor
            ->setStrCollectionCode(self::COLLECTION_CODE)
            ->setObjStartDate($objStartDate)
            ->setObjEndDate($objEndDate)
            ->setStrDocClass(self::DOC_CLASS)
            ->setStrTitle(self::TITLE)
            ->setStrPackageId(self::PACKAGE_ID);
            
        $this->assertEquals(self::COLLECTION_CODE, $objRequestor->getStrCollectionCode());
        $this->assertEquals(self::DOC_CLASS, $objRequestor->getStrDocClass());
        $this->assertEquals(self::TITLE, $objRequestor->getStrTitle());
        $this->assertEquals(self::PACKAGE_ID, $objRequestor->getStrPackageId());
        $this->assertEquals($objStartDate, $objRequestor->getObjStartDate());
        $this->assertEquals($objEndDate, $objRequestor->getObjEndDate());
    }
}