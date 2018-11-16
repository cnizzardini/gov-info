<?php
namespace Cnizzardini\GovInfo;

class Api
{
    const URL = 'https://api.govinfo.gov/';
    private $objHttp;
    
    public function __construct($objHttp)
    {
        $this->objHttp = $objHttp;
    }
    
    public function get($strEndPoint)
    {
        //$this->objHttp->get
    }
    
    public function getObjHttp()
    {
        return $this->objHttp;
    }
}