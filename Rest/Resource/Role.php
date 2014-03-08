<?php
/**
 * This file is part of the Everon framework.
 *
 * (c) Oliwier Ptak <oliwierptak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Everon\Rest\Resource;

use Everon\Helper;
use Everon\Interfaces\Collection;

/**
 * @property \Everon\Domain\Zone\Entity $DomainEntity
 */
abstract class Role extends \Everon\Rest\Resource
{
    protected $relation_definition = [
        'permissions' => 'Permission'
    ];
}
