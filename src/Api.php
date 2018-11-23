<?php

namespace Cnizzardini\GovInfo;

use \GuzzleHttp\Psr7\Uri;
use \GuzzleHttp\Client;

final class Api
{
    private const URL = 'api.govinfo.gov';
    private $objHttp;
    private $strApiKey;
    
    /**
     * Construct an instance
     * 
     * @param Client $objHttp
     * @param string $strApiKey
     */
    public function __construct(Client $objHttp, string $strApiKey)
    {
        $this->objHttp = $objHttp;
        $this->strApiKey = $strApiKey;
    }
    
    /**
     * HTTP GET
     * 
     * @param Uri $objUri
     * @return \GuzzleHttp\Psr7\Response
     */
    public function get(Uri $objUri) : \GuzzleHttp\Psr7\Response
    {
        if (empty($objUri->getPath())) {
            throw new \LogicException('Uri must contain a valid path');
        }
        
        $objUri = $objUri->withHost(self::URL)->withScheme('https');
        $objUri = $objUri->withQueryValue($objUri, 'api_key', $this->strApiKey);

        return $this->objHttp->get($objUri);
    }
    
    /**
     * Performs HTTP GET and returns as an object
     * 
     * @param Uri $objUri
     * @return array
     */
    public function getArray(Uri $objUri) : array
    {
        $objResponse = $this->get($objUri);
        return json_decode($objResponse->getBody()->getContents(), true);
    }
    
    /**
     * Return Guzzle Client
     * 
     * @return \GuzzleHttp\Client
     */
    public function getObjHttp() : Client
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