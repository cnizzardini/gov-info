<?php
namespace Cnizzardini\GovInfo;

class Collection
{
    const COLLECTIONS_ENDPOINT = 'collections';
    
    public function __construct(\Cnizzardini\GovInfo\Api $objApi)
    {
        $this->objApi = $objApi;
    }
    
    public function get()
    {
        return $this->objApi->get(self::COLLECTIONS_ENDPOINT);
    }  
}