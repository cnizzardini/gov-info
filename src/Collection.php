<?php

namespace Cnizzardini\GovInfo;

class Collection
{
    const COLLECTIONS_ENDPOINT = 'collections';
    
    /**
     * Constructs an instance
     * 
     * @param \Cnizzardini\GovInfo\Api $objApi
     */
    public function __construct(\Cnizzardini\GovInfo\Api $objApi)
    {
        $this->objApi = $objApi;
    }
    
    /**
     * Returns collections available
     * 
     * @return \stdClass
     */
    public function get() : \stdClass
    {
        return $this->objApi->get(self::COLLECTIONS_ENDPOINT);
    }  
}