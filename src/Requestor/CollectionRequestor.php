<?php
namespace Cnizzardini\GovInfo\Requestor;

class CollectionRequestor
{
    private $strCollectionCode = '',
            $objStartDate = null,
            $objEndDate = null,
            $intPageSize = 100,
            $intOffSet = 0,
            $strDocClass = '';
    
    /**
     * 
     * @param string $strCollectionCode
     */
    public function setStrCollectionCode(string $strCollectionCode)
    {
        $this->strCollectionCode = $strCollectionCode;
    }
    
    /**
     * 
     * @param \DateTime $objStartDate
     */
    public function setObjStartDate(\DateTime $objStartDate)
    {
        $this->objStartDate = $objStartDate;
    }
    
    /**
     * 
     * @param \DateTime $objEndDate
     */
    public function setObjEndDate(\DateTime $objEndDate)
    {
        $this->objEndDate = $objEndDate;
    }
    
    /**
     * 
     * @param int $intPageSize
     * @throws \LogicException
     */
    public function setIntPageSize(int $intPageSize)
    {
        if ($intPageSize < 1) {
            throw new \LogicException('Pagesize must be greater than zero');
        }
        
        $this->intPageSize = $intPageSize;
    }
    
    /**
     * 
     * @param int $intOffSet
     * @throws \LogicException
     */
    public function setIntOffSet(int $intOffSet)
    {
        if ($intOffSet < 0) {
            throw new \LogicException('Offset must be greater than or equal to zero');
        }
        
        $this->intOffSet = $intOffSet;
    }
    
    /**
     * 
     * @param string $strDocClass
     */
    public function setStrDocClass(string $strDocClass)
    {
        $this->strDocClass = $strDocClass;
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
}