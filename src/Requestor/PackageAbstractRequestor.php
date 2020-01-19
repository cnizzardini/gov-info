<?php

namespace GovInfo\Requestor;

final class PackageAbstractRequestor extends AbstractRequestor
{
    private $strPackageId = '';
    private $strGranuleId = '';
    private $strContentType = '';

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

    public function getStrPackageId() : string
    {
        return $this->strPackageId;
    }

    public function getStrGranuleId() : string
    {
        return $this->strGranuleId;
    }

    public function getStrContentType() : string
    {
        return $this->strContentType;
    } 
}