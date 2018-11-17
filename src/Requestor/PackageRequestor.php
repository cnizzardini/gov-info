<?php
namespace Cnizzardini\GovInfo\Requestor;

class PackageRequestor
{
    private $strPackgeId = '',
            $strGranuleId = '',
            $strContentType = '';

    /**
     * 
     * @param string $strPackgeId
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setStrPackgeId(string $strPackgeId) 
    {
        $this->strPackgeId = $strPackgeId;
        return $this;
    }

    /**
     * 
     * @param string $strGranuleId
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setStrGranuleId(string $strGranuleId) {
        $this->strGranuleId = $strGranuleId;
        return $this;
    }
    
    /**
     * 
     * @param string $strContentType
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setStrContentType(string $strContentType) {
        $this->strContentType = $strContentType;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getStrPackgeId() 
    {
        return $this->strPackgeId;
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