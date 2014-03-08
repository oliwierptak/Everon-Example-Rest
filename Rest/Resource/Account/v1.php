<?php
/**
 * This file is part of the Everon framework.
 *
 * (c) Oliwier Ptak <oliwierptak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Everon\Rest\Resource\Account;

class v1 extends \Everon\Rest\Resource\Account
{
    protected function getToArray()
    {
        $this->DomainEntity->setSecret('***');
        return parent::getToArray();
    }
}
