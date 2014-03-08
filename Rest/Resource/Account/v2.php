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

class v2 extends v1
{
    protected function getToArray()
    {
        $this->DomainEntity->setZoneId('***');
        return parent::getToArray();
    }
}
