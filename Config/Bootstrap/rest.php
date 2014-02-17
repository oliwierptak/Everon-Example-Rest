<?php
namespace Everon;

$nesting = implode('..', array_fill(0, 3, DIRECTORY_SEPARATOR));
$EVERON_ROOT =  realpath(dirname(__FILE__).$nesting).DIRECTORY_SEPARATOR;
$EVERON_SOURCE_ROOT = implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..', '..', 'vendor', 'everon', 'everon', 'src', 'Everon']).DIRECTORY_SEPARATOR;

require_once(
implode(DIRECTORY_SEPARATOR,
    [$EVERON_SOURCE_ROOT, 'Config', 'Bootstrap.php'])
);

/**
 * @var Bootstrap $Bootstrap
 * @var Interfaces\Environment $Environment
 * @var Interfaces\DependencyContainer $Container
 * @var Interfaces\Factory $Factory
 */

$Bootstrap->getClassLoader()->add('Everon\DataMapper', $Environment->getDataMapper());
$Bootstrap->getClassLoader()->add('Everon\Domain', $Environment->getDomain());
$Bootstrap->getClassLoader()->add('Everon\Module', $Environment->getModule());


$Container->register('Request', function() use ($Factory) {
    return $Factory->buildRequest($_SERVER, $_GET, $_POST, $_FILES, 'Everon\Rest');
});

//replace default Router
$Container->register('Router', function() use ($Factory) {
    $RouteConfig = $Factory->getDependencyContainer()->resolve('ConfigManager')->getConfigByName('router');
    $RequestValidator = $Factory->buildRequestValidator();
    return $Factory->buildRouter($RouteConfig, $RequestValidator, 'Everon\Rest');
});

$Container->register('ConnectionManager', function() use ($Factory) {
    $Factory->getDependencyContainer()->monitor('ConnectionManager', ['Everon\Config\Manager']);
    $DatabaseConfig = $Factory->getDependencyContainer()->resolve('ConfigManager')->getDatabaseConfig();
    return $Factory->buildConnectionManager($DatabaseConfig);
});

$Container->register('DomainManager', function() use ($Factory) {
    $Factory->getDependencyContainer()->monitor('DomainManager', ['Everon\DataMapper\Connection\Manager']);
    $ConnectionManager = $Factory->getDependencyContainer()->resolve('ConnectionManager');
    return $Factory->buildDomainManager($ConnectionManager);
});