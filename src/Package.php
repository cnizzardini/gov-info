<?php

namespace GovInfo;

use GuzzleHttp\Psr7\Uri;
use GovInfo\Requestor\PackageRequestor;

final class Package
{
    private const ENDPOINT = 'packages';
    
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
     * Gets package summary
     * 
     * @param PackageRequestor $objRequestor
     * @return array
     * @throws \LogicException
     */
    public function summary(PackageRequestor $objRequestor) : array
    {
        $this->requireStrPackageId($objRequestor);
        
        $objUri = new Uri();
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::ENDPOINT . '/' . $objRequestor->getStrPackageId() . '/summary';
        
        return $this->objApi->getArray($objUri->withPath($strPath));
    }
    
    /**
     * Gets a package of a specified content type
     * 
     * @param PackageRequestor $objRequestor
     * @return \GuzzleHttp\Psr7\Response
     * @throws \LogicException
     */
    public function contentType(PackageRequestor $objRequestor) : \GuzzleHttp\Psr7\Response
    {
        $this->requireStrPackageId($objRequestor);
        
        if (empty($objRequestor->getStrContentType())) {
            throw new \LogicException('PackageRequestor::getStrContentType is required');
        }
        
        $objUri = new Uri();
        
        $strPath = self::ENDPOINT . '/' . $objRequestor->getStrPackageId() . '/';
        $strPath.= $objRequestor->getStrContentType();
        
        return $this->objApi->get($objUri->withPath($strPath));
    }
    
    /**
     * Gets a packages granules
     * 
     * @param PackageRequestor $objRequestor
     * @return \stdClass
     * @throws \LogicException
     */
    public function granules(PackageRequestor $objRequestor) : array
    {
        $this->requireStrPackageId($objRequestor);
        
        $objUri = new Uri();
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::ENDPOINT . '/' . $objRequestor->getStrPackageId() . '/granules';

        return $this->objApi->getArray($objUri->withPath($strPath));
    }
    
    /**
     * Get granule summary
     * 
     * @param \GovInfo\Requestor\PackageRequestor $objRequestor
     * @return array
     * @throws \LogicException
     */
    public function granuleSummary(PackageRequestor $objRequestor) : array
    {
        $this->requireStrPackageId($objRequestor);
        
        if (empty($objRequestor->getStrGranuleId())) {
            throw new \LogicException('PackageRequestor::strGranuleId is required');
        }
        
        $objUri = new Uri();
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::ENDPOINT . '/' . $objRequestor->getStrPackageId() . '/granules/';
        $strPath.= $objRequestor->getStrGranuleId() . '/summary';
        
        return $this->objApi->getArray($objUri->withPath($strPath));
    }

    private function requireStrPackageId(PackageRequestor $objRequestor) : void
    {
        if (empty($objRequestor->getStrPackageId())) {
            throw new \LogicException('PackageRequestor::getStrPackageId is required');
        }
    }
}