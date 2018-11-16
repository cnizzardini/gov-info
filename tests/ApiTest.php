<?php
use PHPUnit\Framework\TestCase;
use Cnizzardini\GovInfo\Api;

class ApiTest extends TestCase
{
    const KEY = 'DEMO_KEY';
    
    public function testConstructGuzzle()
    {
        $objApi = new Api(new \GuzzleHttp\Client(), self::KEY);
        $this->assertInstanceOf('\Cnizzardini\GovInfo\Api', $objApi);
    }
}