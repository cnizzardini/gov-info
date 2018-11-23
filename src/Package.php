<?php

namespace Cnizzardini\GovInfo;

use GuzzleHttp\Psr7\Uri;
use Cnizzardini\GovInfo\Requestor\PackageRequestor;

final class Package
{
    const ENDPOINT = 'packages';
    
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
     * Gets package summary
     * 
     * @param \Cnizzardini\GovInfo\Requestor\PackageRequestor $objRequestor
     * @return \stdClass
     * @throws \LogicException
     */
    public function summary(PackageRequestor $objRequestor) : \stdClass
    {
        if (empty($objRequestor->getStrPackageId())) {
            throw new \LogicException('PackageRequestor::strCollectionCode is required');
        }
        
        $objUri = new Uri();
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::ENDPOINT . '/' . $objRequestor->getStrPackageId() . '/summary';
        
        $objResult = $this->objApi->getObject($objUri->withPath($strPath));
        
        return $objResult;
    }
    
    /**
     * Gets a package of a specified content type
     * 
     * @param \Cnizzardini\GovInfo\Requestor\PackageRequestor $objRequestor
     * @return \GuzzleHttp\Psr7\Response
     * @throws \LogicException
     */
    public function contentType(PackageRequestor $objRequestor) : \GuzzleHttp\Psr7\Response
    {
        if (empty($objRequestor->getStrPackageId())) {
            throw new \LogicException('PackageRequestor::strCollectionCode is required');
        }
        
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
     * @param \Cnizzardini\GovInfo\Requestor\PackageRequestor $objRequestor
     * @return \stdClass
     * @throws \LogicException
     */
    public function granules(PackageRequestor $objRequestor) : \stdClass
    {
        if (empty($objRequestor->getStrPackageId())) {
            throw new \LogicException('PackageRequestor::strCollectionCode is required');
        }
        
        $objUri = new Uri();
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::ENDPOINT . '/' . $objRequestor->getStrPackageId() . '/granules';
        
        $objResult = $this->objApi->getObject($objUri->withPath($strPath));
        
        return $objResult;
    }
    
    /**
     * Get granule summary
     * 
     * @param \Cnizzardini\GovInfo\Requestor\PackageRequestor $objRequestor
     * @return \stdClass
     * @throws \LogicException
     */
    public function granuleSummary(PackageRequestor $objRequestor) : \stdClass
    {
        if (empty($objRequestor->getStrPackageId())) {
            throw new \LogicException('PackageRequestor::strCollectionCode is required');
        }
        
        if (empty($objRequestor->getStrGranuleId())) {
            throw new \LogicException('PackageRequestor::strGranuleId is required');
        }
        
        $objUri = new Uri();
        $objUri = $objUri->withQueryValue($objUri, 'pageSize', $objRequestor->getIntPageSize());
        $objUri = $objUri->withQueryValue($objUri, 'offset', $objRequestor->getIntOffSet());
        
        $strPath = self::ENDPOINT . '/' . $objRequestor->getStrPackageId() . '/granules/';
        $strPath.= $objRequestor->getStrGranuleId() . '/summary';
        
        $objResult = $this->objApi->getObject($objUri->withPath($strPath));
        
        return $objResult;
    }
}