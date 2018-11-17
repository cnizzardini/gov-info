<?php

namespace Cnizzardini\GovInfo;
use GuzzleHttp\Psr7\Uri;

class Collection
{
    const ENDPOINT = 'collections';
    
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
        return $this->objApi->get($objUri->withPath(self::ENDPOINT));
    }
    
    /**
     * Returns a type of collection
     * 
     * @param \Cnizzardini\GovInfo\Requestor\Collection $objRequestor
     * @return \stdClass
     */
    public function item(\Cnizzardini\GovInfo\Requestor\CollectionRequestor $objRequestor) : \stdClass
    {
        if (empty($objRequestor->getStrCollectionCode())) {
            throw new \LogicException('CollectionRequestor::strCollectionCode is required');
        }
        
        $objUri = new Uri();
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::ENDPOINT . '/' . $objRequestor->getStrCollectionCode();
        
        if ($objRequestor->getObjStartDate()) {
            $strPath.= '/' . urlencode($objRequestor->getObjStartDate()->format('Y-m-d H:i:s'));
        }
        
        if ($objRequestor->getObjEndDate()) {
            $strPath.= '/' . urlencode($objRequestor->getObjEndDate()->format('Y-m-d H:i:s'));
        }
        
        $objResult = $this->objApi->get($objUri->withPath($strPath));
        
        return $this->filterPackages($objResult, $objRequestor);
    }
    
    /**
     * Filters packages
     * 
     * @param \stdClass $objResult
     * @param \Cnizzardini\GovInfo\Requestor\CollectionRequestor $objRequestor
     * @return \stdClass
     */
    private function filterPackages(\stdClass $objResult, \Cnizzardini\GovInfo\Requestor\CollectionRequestor $objRequestor) : \stdClass
    {
        $strDocClass = $objRequestor->getStrDocClass();
        $strTitle = $objRequestor->getStrTitle();
        $strPackageId = $objRequestor->getStrPackageId();
        
        if (!empty($strDocClass)) {
            $objResult->packages = array_filter($objResult->packages, function($objPackage) use ($strDocClass) {
                if ($objPackage->docClass == $strDocClass) {
                    return $objPackage;
                }
            });
        }
        
        if (!empty($strTitle)) {
            $objResult->packages = array_filter($objResult->packages, function($objPackage) use ($strTitle) {
                if (preg_match("/$strTitle/i", $objPackage->title)) {
                    return $objPackage;
                }
            });
        }
        
        if (!empty($strPackageId)) {
            $objResult->packages = array_filter($objResult->packages, function($objPackage) use ($strPackageId) {
                if ($objPackage->packageId == $strPackageId) {
                    return $objPackage;
                }
            });
        }
        
        return $objResult;
    }
}