<?php
namespace Cnizzardini\GovInfo\Requestor;

class CollectionRequestor
{
    private $strCollectionCode = '',
            $objStartDate = null,
            $objEndDate = null,
            $intPageSize = 100,
            $intOffSet = 0,
            $strDocClass = '',
            $strTitle = '',
            $strPackageId = '';
    
    /**
     * 
     * @param string $strCollectionCode
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setStrCollectionCode(string $strCollectionCode)
    {
        $this->strCollectionCode = $strCollectionCode;
        return $this;
    }
    
    /**
     * 
     * @param \DateTime $objStartDate
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setObjStartDate(\DateTime $objStartDate)
    {
        $this->objStartDate = $objStartDate;
        return $this;
    }
    
    /**
     * 
     * @param \DateTime $objEndDate
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setObjEndDate(\DateTime $objEndDate)
    {
        $this->objEndDate = $objEndDate;
        return $this;
    }
    
    /**
     * 
     * @param int $intPageSize
     * @return Cnizzardini\GovInfo\Requestor
     * @throws \LogicException
     */
    public function setIntPageSize(int $intPageSize)
    {
        if ($intPageSize < 1) {
            throw new \LogicException('Pagesize must be greater than zero');
        }
        
        $this->intPageSize = $intPageSize;
        return $this;
    }
    
    /**
     * 
     * @param int $intOffSet
     * @return Cnizzardini\GovInfo\Requestor
     * @throws \LogicException
     */
    public function setIntOffSet(int $intOffSet)
    {
        if ($intOffSet < 0) {
            throw new \LogicException('Offset must be greater than or equal to zero');
        }
        
        $this->intOffSet = $intOffSet;
        return $this;
    }
    
    /**
     * 
     * @param string $strDocClass
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setStrDocClass(string $strDocClass)
    {
        $this->strDocClass = $strDocClass;
        return $this;
    }
    
    /**
     * 
     * @param string $strTitle
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setTitle(string $strTitle)
    {
        $this->strTitle = $strTitle;
        return $this;
    }
    
    /**
     * 
     * @param string $strPackageId
     * @return Cnizzardini\GovInfo\Requestor
     */
    public function setStrPackageId(string $strPackageId)
    {
        $this->strPackageId = $strPackageId;
        return $this;
    }    
    
    /**
     * 
     * @return string
     */
    public function getStrCollectionCode()
    {
        return $this->strCollectionCode;
    }
    
    /**
     * 
     * @return \DateTime|null
     */
    public function getObjStartDate()
    {
        return $this->objStartDate;
    }
    
    /**
     * 
     * @return \DateTime|null
     */
    public function getObjEndDate()
    {
        return $this->objEndDate;
    }
    
    /**
     * 
     * @return int|null
     */
    public function getIntPageSize()
    {
        return $this->intPageSize;
    }
    
    /**
     * 
     * @return int|null
     */
    public function getIntOffSet()
    {
        return $this->intOffSet;
    }
    
    /**
     * 
     * @return string
     */
    public function getStrDocClass()
    {
        return $this->strDocClass;
    }
    
    /**
     * 
     * @return string
     */
    public function getStrTitle()
    {
        return $this->strTitle;
    }
    
    /**
     * 
     * @return string
     */
    public function getStrPackageId()
    {
        return $this->strPackageId;
    } 
}