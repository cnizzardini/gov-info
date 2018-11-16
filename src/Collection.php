<?php

namespace Cnizzardini\GovInfo;
use GuzzleHttp\Psr7\Uri;

class Collection
{
    const COLLECTIONS_ENDPOINT = 'collections';
    const BILLS = 'BILLS';
    
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
    public function get() : \stdClass
    {
        $objUri = new Uri();
        return $this->objApi->get($objUri->withPath(self::COLLECTIONS_ENDPOINT));
    }
    
    /**
     * 
     */
    public function bills(\Cnizzardini\GovInfo\Requestor\BillCollection $objRequestor) : \stdClass
    {
        $objUri = new Uri();
        
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::COLLECTIONS_ENDPOINT . '/' . self::BILLS;
        
        if ($objRequestor->getObjStartDate()) {
            $strPath.= '/' . urlencode($objRequestor->getObjStartDate()->format('Y-m-d H:i:s'));
        }
        
        if ($objRequestor->getObjEndDate()) {
            $strPath.= '/' . urlencode($objRequestor->getObjEndDate()->format('Y-m-d H:i:s'));
        }
        
        return $this->objApi->get($objUri->withPath($strPath));
    }
}