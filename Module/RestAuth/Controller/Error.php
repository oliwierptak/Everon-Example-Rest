<?php

namespace Everon\Module\RestAuth\Controller;

use Everon\Dependency;
use Everon\Interfaces;
use Everon\Rest;

/**
 * @method \Everon\Module\RestAuth\Module getModule()
 */
class Error extends Rest\Controller implements Rest\Interfaces\Controller
{
    public function show()
    {
        dd($this);
        dd($this->getRequest(), $this->getResponse());
    }
}