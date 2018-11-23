<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Cnizzardini\GovInfo\Api;
use Cnizzardini\GovInfo\Package;
use Cnizzardini\GovInfo\Requestor\PackageRequestor;

class PackageTest extends TestCase
{
    const KEY = 'DEMO_KEY';
    const FIXTURES = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
    
    public function testSummary()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'package-summary.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objRequestor = new PackageRequestor();
        $objRequestor->setStrPackageId('BILLS-115hr4033rfs');
        
        $objPackage = new Package($objApi);
        $arrResult = $objPackage->summary($objRequestor);
        
        $this->assertEquals('BILLS-115hr4033rfs', $arrResult['packageId']);
    }
    
    public function testContentTypeXml()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'package-content-type.xml')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objRequestor = new PackageRequestor();
        $objRequestor->setStrPackageId('BILLS-115hr4033rfs')->setStrContentType('xml');
        
        $objPackage = new Package($objApi);
        $objResponse = $objPackage->contentType($objRequestor);
        $strBody = $objResponse->getBody()->getContents();
        
        $objXml = simplexml_load_string($strBody);
        $arrXml = get_object_vars($objXml->form);
        
        $this->assertEquals('H. R. 4033', $arrXml['legis-num']);
    }
    
    public function testGranules()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'package-granules.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objRequestor = new PackageRequestor();
        $objRequestor->setStrPackageId('CREC-2018-01-04');
        
        $objPackage = new Package($objApi);
        $arrResult = $objPackage->granules($objRequestor);
        $arrGranule = reset($arrResult['granules']);
        
        $this->assertEquals('CREC-2018-01-04-pt1-PgD7', $arrGranule['granuleId']);
    }
    
    public function testGranuleSummary()
    {
        $objMockHandler = new MockHandler();
        $objMockHandler->append(new Response(200, [], file_get_contents(self::FIXTURES . 'package-granule-summary.json')));
        $objClient = new Client([
            'handler' => $objMockHandler
        ]);
        
        $objApi = new Api($objClient, self::KEY);
        $objRequestor = new PackageRequestor();
        $objRequestor->setStrPackageId('CREC-2018-01-04');
        $objRequestor->setStrGranuleId('CREC-2018-01-04-pt1-PgD7-3');
        
        $objPackage = new Package($objApi);
        $arrResult = $objPackage->granuleSummary($objRequestor);
        
        $this->assertEquals('CREC-2018-01-04-pt1-PgD7-3', $arrResult['granuleId']);
    }
}