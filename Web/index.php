<?php
/**
 * Everon application example.
 */
namespace Everon;

$system_memory = (string) (memory_get_usage(true));
error_reporting(E_ALL);

/**
 * @var Guid $Guid
 * @var Interfaces\Factory $Factory
 * @var Interfaces\Core $RestServer
 */
require_once(
    implode(DIRECTORY_SEPARATOR,
        [dirname(__FILE__), '..', 'Config', 'Bootstrap', 'rest.php']));

$Guid->setSystemMemoryAtStart($system_memory);
$RestServer = $Factory->buildRest();
$RestServer->run($Guid);