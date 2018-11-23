<?php

namespace Cnizzardini\GovInfo;

use GuzzleHttp\Psr7\Uri;
use Cnizzardini\GovInfo\Requestor\CollectionRequestor;

final class Collection
{
    private const ENDPOINT = 'collections';
    
    /**
     * Constructs an instance
     * 
     * @param Api $objApi
     */
    public function __construct(Api $objApi)
    {
        $this->objApi = $objApi;
    }
    
    /**
     * Returns collections available
     * 
     * @return array
     */
    public function index() : array
    {
        $objUri = new Uri();
        return $this->objApi->getArray($objUri->withPath(self::ENDPOINT));
    }

    /**
     * Returns a type of collection
     *
     * @param CollectionRequestor $objRequestor
     * @return array
     */
    public function item(CollectionRequestor $objRequestor) : array
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
        
        $objResult = $this->objApi->getArray($objUri->withPath($strPath));
        
        return $this->filterPackages($objResult, $objRequestor);
    }

    /**
     * Filters packages
     *
     * @param array $arrResult
     * @param CollectionRequestor $objRequestor
     * @return array
     */
    private function filterPackages(array $arrResult, CollectionRequestor $objRequestor) : array
    {
        $strDocClass = $objRequestor->getStrDocClass();
        $strTitle = $objRequestor->getStrTitle();
        $strPackageId = $objRequestor->getStrPackageId();
        
        if (!empty($strDocClass)) {
            $arrResult['packages'] = array_filter($arrResult['packages'], function($arrPackage) use ($strDocClass) {
                if ($arrPackage['docClass'] == $strDocClass) {
                    return $arrPackage;
                }
            });
        }
        
        if (!empty($strTitle)) {
            $arrResult['packages'] = array_filter($arrResult['packages'], function($arrResult) use ($strTitle) {
                if (preg_match("/$strTitle/i", $arrResult['title'])) {
                    return $arrResult;
                }
            });
        }
        
        if (!empty($strPackageId)) {
            $arrResult['packages'] = array_filter($arrResult['packages'], function($arrResult) use ($strPackageId) {
                if ($arrResult['packageId'] == $strPackageId) {
                    return $arrResult;
                }
            });
        }
        
        return $arrResult;
    }
}