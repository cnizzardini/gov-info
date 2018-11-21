<?php

namespace Cnizzardini\GovInfo\Requestor;

abstract class Requestor
{
    private $intPageSize = 100,
            $intOffSet = 0;
    
    /**
     * 
     * @param int $intPageSize
     * @return self
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
     * @return self
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
     * @return int
     */
    public function getIntPageSize()
    {
        return $this->intPageSize;
    }
    
    /**
     * 
     * @return int
     */
    public function getIntOffSet()
    {
        return $this->intOffSet;
    }
}