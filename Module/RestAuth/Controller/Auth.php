<?php

namespace Everon\Module\RestAuth\Controller;

use Everon\Dependency;
use Everon\Interfaces;
use Everon\Rest;

/**
 * @method \Everon\Module\RestAuth\Module getModule()
 */
class Auth extends Rest\Controller implements Rest\Interfaces\Controller
{
    public function login()
    {
        die('auth login');
    }
}