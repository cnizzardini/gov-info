<?php
use PHPUnit\Framework\TestCase;
use Cnizzardini\GovInfo\Requestor\Requestor;

class RequestorTest extends TestCase
{
    const PAGE_SIZE = 1000;
    const OFF_SET = 3;
    
    public function testObject()
    {
        $objRequestor = new Requestor();
        $objRequestor->setIntPageSize(self::PAGE_SIZE)->setIntOffSet(self::OFF_SET);
        $this->assertEquals(self::PAGE_SIZE, $objRequestor->getIntPageSize());
        $this->assertEquals(self::OFF_SET, $objRequestor->getIntOffSet());
    }
}