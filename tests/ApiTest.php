<?php
use PHPUnit\Framework\TestCase;
use Cnizzardini\GovInfo\Api;

class ApiTest extends TestCase
{
    public function setUp()
    {
        
    }
    
    public function testConstructGuzzle()
    {
        $objApi = new Api(new \GuzzleHttp\Client());
        $this->assertInstanceOf('\GuzzleHttp\Client', $objApi->getObjHttp());
    }
}