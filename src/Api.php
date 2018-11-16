<?php

namespace Cnizzardini\GovInfo;

class Api
{
    const URL = 'https://api.govinfo.gov/';
    private $objHttp;
    private $strApiKey;
    
    /**
     * Construct an instance
     * 
     * @param \GuzzleHttp\Client $objHttp
     * @param string $strApiKey
     */
    public function __construct(\GuzzleHttp\Client $objHttp, string $strApiKey)
    {
        $this->objHttp = $objHttp;
        $this->strApiKey = $strApiKey;
    }
    
    /**
     * HTTP GET
     * 
     * @param string $strEndPoint
     * @return \stdClass
     */
    public function get(string $strEndPoint) : \stdClass
    {
        $strUrl = ''; //self::URL . $strEndPoint . '?api_key=' . $this->strApiKey;
        $objResponse = $this->objHttp->get($strUrl);
        return json_decode($objResponse->getBody()->getContents());
    }
    
    /**
     * Return Guzzle Client
     * 
     * @return \GuzzleHttp\Client
     */
    public function getObjHttp() : \GuzzleHttp\Client
    {
        return $this->objHttp;
    }
    
    /**
     * Return API Key
     * 
     * @return string
     */
    public function getStrKey() : string
    {
        return $this->strApiKey;
    }    
}