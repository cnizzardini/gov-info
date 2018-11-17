<?php

namespace Cnizzardini\GovInfo\Requestor;

use Cnizzardini\GovInfo\Requestor\Requestor;

class PackageRequestor extends Requestor
{
    private $strPackageId = '',
            $strGranuleId = '',
            $strContentType = '',
            $intPageSize = 100,
            $intOffSet = 0;

    /**
     * 
     * @param string $strPackgeId
     * @return Cnizzardini\GovInfo\Requestor\PackageRequestor
     */
    public function setStrPackageId(string $strPackageId) 
    {
        $this->strPackageId = $strPackageId;
        return $this;
    }

    /**
     * 
     * @param string $strGranuleId
     * @return Cnizzardini\GovInfo\Requestor\PackageRequestor
     */
    public function setStrGranuleId(string $strGranuleId) {
        $this->strGranuleId = $strGranuleId;
        return $this;
    }
    
    /**
     * 
     * @param string $strContentType
     * @return Cnizzardini\GovInfo\Requestor\PackageRequestor
     */
    public function setStrContentType(string $strContentType) {
        $this->strContentType = $strContentType;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getStrPackageId() 
    {
        return $this->strPackageId;
    }

    /**
     * 
     * @return string
     */    
    public function getStrGranuleId() 
    {
        return $this->strGranuleId;
    }

    /**
     * 
     * @return string
     */
    public function getStrContentType() 
    {
        return $this->strContentType;
    } 
}