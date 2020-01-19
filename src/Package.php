<?php

namespace GovInfo;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Response;
use GovInfo\Requestor\PackageAbstractRequestor;
use LogicException;

final class Package
{
    use EndpointTrait;

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
     * @param PackageAbstractRequestor $objRequestor
     * @return array
     */
    public function summary(PackageAbstractRequestor $objRequestor) : array
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
     * @param PackageAbstractRequestor $objRequestor
     * @return Response
     * @throws LogicException
     */
    public function contentType(PackageAbstractRequestor $objRequestor) : Response
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
     * @param PackageAbstractRequestor $objRequestor
     * @return array
     * @throws LogicException
     */
    public function granules(PackageAbstractRequestor $objRequestor) : array
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
     * @param PackageAbstractRequestor $objRequestor
     * @return array
     * @throws LogicException
     */
    public function granuleSummary(PackageAbstractRequestor $objRequestor) : array
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

    private function requireStrPackageId(PackageAbstractRequestor $objRequestor) : void
    {
        if (empty($objRequestor->getStrPackageId())) {
            throw new \LogicException('PackageRequestor::getStrPackageId is required');
        }
    }
}