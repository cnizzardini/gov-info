<?php
use PHPUnit\Framework\TestCase;
use GovInfo\Requestor\PackageRequestor;

class PackageRequestorTest extends TestCase
{
    const CONTENT_TYPE = 'xml';
    const GRANULE_ID = 'ABC-XYZ';
    const PACKAGE_ID = 'ABC';
    
    public function testObject()
    {
        $objRequestor = new PackageRequestor();
        $objRequestor
            ->setStrContentType(self::CONTENT_TYPE)
            ->setStrGranuleId(self::GRANULE_ID)
            ->setStrPackageId(self::PACKAGE_ID);
            
        $this->assertEquals(self::CONTENT_TYPE, $objRequestor->getStrContentType());
        $this->assertEquals(self::GRANULE_ID, $objRequestor->getStrGranuleId());
        $this->assertEquals(self::PACKAGE_ID, $objRequestor->getStrPackageId());
    }
}