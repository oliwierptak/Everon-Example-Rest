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
if ($Bootstrap->useEveronAutoload()) {
    $Bootstrap->getClassLoader()->add('Everon\DataMapper', $Environment->getDataMapper());
    $Bootstrap->getClassLoader()->add('Everon\Domain', $Environment->getDomain());
    $Bootstrap->getClassLoader()->add('Everon\Module', $Environment->getModule());
    $Bootstrap->getClassLoader()->add('Everon\Rest', $Environment->getRest());
}

$Container->register('Request', function() use ($Factory) {
    $Factory->getDependencyContainer()->monitor('Request', ['Everon\Config\Manager']);
    $ConfigManager = $Factory->getDependencyContainer()->resolve('ConfigManager');
    $versioning = $ConfigManager->getConfigValue('application.rest.versioning', 'url');
    
    $post = json_decode(file_get_contents('php://input'), true);
    if ($post === null) {
        $post = [];
    }
    
    return $Factory->buildRestRequest($_SERVER, $_GET, $post, $_FILES, $versioning);
});

$Container->register('Response', function() use ($Factory) {
    $Factory->getDependencyContainer()->monitor('Response', ['Everon\RequestIdentifier']);
    $RequestIdentifier = $Factory->getDependencyContainer()->resolve('RequestIdentifier');
    $Headers = $Factory->buildHttpHeaderCollection([]);
    return $Factory->buildRestResponse($RequestIdentifier->getValue(), $Headers);
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

$Container->register('ResourceManager', function() use ($Factory) {
    $Factory->getDependencyContainer()->monitor('ResourceManager', ['Everon\Config\Manager']);
    $ConfigManager = $Factory->getDependencyContainer()->resolve('ConfigManager');
    
    $rest = $ConfigManager->getConfigValue('rest.rest');
    $versioning = $ConfigManager->getConfigValue('rest.versioning');
    $mapping = $ConfigManager->getConfigValue('rest.mapping');
    $rest_server_url = $rest['protocol'].$rest['host'].':'.$rest['port'].$rest['url'];
    return $Factory->buildRestResourceManager($rest_server_url, $versioning['supported_versions'], $versioning['type'], $mapping);
});