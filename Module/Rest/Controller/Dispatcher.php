<?php

namespace Everon\Module\Rest\Controller;

use Everon\Interfaces;
use Everon\Rest;

class Dispatcher extends Rest\Controller implements Rest\Interfaces\Controller
{
    public function serve()
    {
        $Resource = $this->getResourceFromRequest();
        $this->getResponse()->setData($Resource);       
    }
    
    /**
     * @return Interfaces\Resource
     */
    public function getResourceFromRequest()
    {
        $version = $this->getRequest()->getVersion();
        $resource_id = $this->getRequest()->getQueryParameter('resource_id', null);
        $resource_name = $this->getRequest()->getQueryParameter('resource', null);
        $Navigator = $this->getFactory()->buildRestResourceNavigator($this->getRequest());

        if ($resource_id === null) {
            $Resource = $this->getResourceManager()->getCollectionResource($resource_name, $version);
        }
        else {
            $Resource = $this->getResourceManager()->getResource($resource_id, $resource_name, $version, $Navigator);
        }
        
        return $Resource;
    }
}