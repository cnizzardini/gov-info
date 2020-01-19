<?php

namespace GovInfo;

trait EndpointTrait
{
    public function getObjApi() : Api
    {
        return $this->objApi;
    }
}