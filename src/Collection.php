<?php

namespace Cnizzardini\GovInfo;
use GuzzleHttp\Psr7\Uri;

class Collection
{
    const COLLECTIONS_ENDPOINT = 'collections';
    
    /**
     * Constructs an instance
     * 
     * @param \Cnizzardini\GovInfo\Api $objApi
     */
    public function __construct(\Cnizzardini\GovInfo\Api $objApi)
    {
        $this->objApi = $objApi;
    }
    
    /**
     * Returns collections available
     * 
     * @return \stdClass
     */
    public function index() : \stdClass
    {
        $objUri = new Uri();
        return $this->objApi->get($objUri->withPath(self::COLLECTIONS_ENDPOINT));
    }
    
    /**
     * 
     * @param string $type
     * @param \Cnizzardini\GovInfo\Requestor\Collection $objRequestor
     * @return \stdClass
     */
    public function item(string $strCollectionCode, \Cnizzardini\GovInfo\Requestor\CollectionRequestor $objRequestor) : \stdClass
    {
        $objUri = new Uri();
        
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::COLLECTIONS_ENDPOINT . '/' . $strCollectionCode;
        
        if ($objRequestor->getObjStartDate()) {
            $strPath.= '/' . urlencode($objRequestor->getObjStartDate()->format('Y-m-d H:i:s'));
        }
        
        if ($objRequestor->getObjEndDate()) {
            $strPath.= '/' . urlencode($objRequestor->getObjEndDate()->format('Y-m-d H:i:s'));
        }
        
        return $this->objApi->get($objUri->withPath($strPath));
    }
}