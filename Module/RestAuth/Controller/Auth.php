<?php

namespace Everon\Module\Auth\Controller;

use Everon\Dependency;
use Everon\Interfaces;
use Everon\Rest;

/**
 * @method \Everon\Module\Auth\Module getModule()
 */
class Auth extends Rest\Controller implements Rest\Interfaces\Controller
{
    public function login()
    {
        die('auth login');
    }
}