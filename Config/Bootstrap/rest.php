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

$Bootstrap->getClassLoader()->add('Everon\Rest\Controller', $Environment->getController().'Console'.DIRECTORY_SEPARATOR);
$Bootstrap->getClassLoader()->add('Everon\DataMapper', $Environment->getDataMapper());
$Bootstrap->getClassLoader()->add('Everon\Domain', $Environment->getDomain());
$Bootstrap->getClassLoader()->add('Everon\Module', $Environment->getModule());

//replace default Router
$Container->register('Router', function() use ($Factory) {
    $RouteConfig = $Factory->getDependencyContainer()->resolve('ConfigManager')->getConfigByName('router');
    $RequestValidator = $Factory->buildRequestValidator();
    return $Factory->buildRouter($RouteConfig, $RequestValidator, 'Everon\Rest');
});