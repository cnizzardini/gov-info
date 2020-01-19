<?php

namespace GovInfo\Requestor;

final class CollectionAbstractRequestor extends AbstractRequestor
{
    private $strCollectionCode = '';
    private $objStartDate = '';
    private $objEndDate = '';
    private $strDocClass = '';
    private $strTitle = '';
    private $strPackageId = '';

    public function setStrCollectionCode(string $strCollectionCode) : self
    {
        $this->strCollectionCode = $strCollectionCode;
        return $this;
    }

    public function setObjStartDate(\DateTime $objStartDate) : self
    {
        $this->objStartDate = $objStartDate;
        return $this;
    }

    public function setObjEndDate(\DateTime $objEndDate) : self
    {
        $this->objEndDate = $objEndDate;
        return $this;
    }

    public function setStrDocClass(string $strDocClass) : self
    {
        $this->strDocClass = $strDocClass;
        return $this;
    }

    public function setStrTitle(string $strTitle) : self
    {
        $this->strTitle = $strTitle;
        return $this;
    }

    public function setStrPackageId(string $strPackageId) : self
    {
        $this->strPackageId = $strPackageId;
        return $this;
    }    

    public function getStrCollectionCode() : string
    {
        return $this->strCollectionCode;
    }

    public function getObjStartDate()
    {
        return $this->objStartDate;
    }

    public function getObjEndDate()
    {
        return $this->objEndDate;
    }

    public function getStrDocClass() : string
    {
        return $this->strDocClass;
    }

    public function getStrTitle() : string
    {
        return $this->strTitle;
    }

    public function getStrPackageId() : string
    {
        return $this->strPackageId;
    } 
}