<?php

namespace Cnizzardini\GovInfo\Requestor;

final class PackageRequestor extends Requestor
{
    private $strPackageId = '',
            $strGranuleId = '',
            $strContentType = '';

    public function setStrPackageId(string $strPackageId) : self
    {
        $this->strPackageId = $strPackageId;
        return $this;
    }

    public function setStrGranuleId(string $strGranuleId) : self
    {
        $this->strGranuleId = $strGranuleId;
        return $this;
    }

    public function setStrContentType(string $strContentType) : self
    {
        $this->strContentType = $strContentType;
        return $this;
    }

    public function getStrPackageId() 
    {
        return $this->strPackageId;
    }

    public function getStrGranuleId() 
    {
        return $this->strGranuleId;
    }

    public function getStrContentType() 
    {
        return $this->strContentType;
    } 
}