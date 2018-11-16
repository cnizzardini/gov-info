<?php
namespace Cnizzardini\GovInfo;

class Api
{
    const URL = 'https://api.govinfo.gov/';
    private $objHttp;
    private $strApiKey;
    
    public function __construct(\GuzzleHttp\Client $objHttp, string $strApiKey)
    {
        $this->objHttp = $objHttp;
        $this->strApiKey = $strApiKey;
    }
    
    public function get($strEndPoint)
    {
        $strUrl = ''; //self::URL . $strEndPoint . '?api_key=' . $this->strApiKey;
        $objResponse = $this->objHttp->get($strUrl);
        return json_decode($objResponse->getBody()->getContents());
    }
    
    public function getObjHttp()
    {
        return $this->objHttp;
    }
    
    public function getStrKey()
    {
        return $this->strApiKey;
    }    
}