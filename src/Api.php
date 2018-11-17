<?php

namespace Cnizzardini\GovInfo;

class Api
{
    const URL = 'api.govinfo.gov';
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
     * @param \GuzzleHttp\Psr7\Uri $objUri
     * @return \stdClass
     */
    public function get(\GuzzleHttp\Psr7\Uri $objUri) : \stdClass
    {
        if (empty($objUri->getPath())) {
            throw new \LogicException('Uri must contain a valid path');
        }
        
        $objUri = $objUri->withHost(self::URL)->withScheme('https');
        
        $objResponse = $this->objHttp->get($objUri->withQueryValue($objUri, 'api_key', $this->strApiKey));
        
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