<?php

namespace Cnizzardini\GovInfo\Requestor;

abstract class Requestor
{
    private $intPageSize = 100,
            $intOffSet = 0;

    public function setIntPageSize(int $intPageSize) : self
    {
        if ($intPageSize < 1) {
            throw new \LogicException('Pagesize must be greater than zero');
        }
        
        $this->intPageSize = $intPageSize;
        return $this;
    }

    public function setIntOffSet(int $intOffSet) : self
    {
        if ($intOffSet < 0) {
            throw new \LogicException('Offset must be greater than or equal to zero');
        }
        
        $this->intOffSet = $intOffSet;
        return $this;
    }

    public function getIntPageSize() : string
    {
        return $this->intPageSize;
    }

    public function getIntOffSet() : string
    {
        return $this->intOffSet;
    }
}