<?php
include_once 'preload.php';
include_once 'autoloader.php';
include_once 'utilities.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;

// Load routes
$locator = new FileLocator([ROOT]);
$loader = new PhpFileLoader($locator);
$routes = $loader->load('config/routes.php');

// Create a RequestContext object for the incoming request
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);

// Instantiate the UrlMatcher
$matcher = new UrlMatcher($routes, $context);

try {
    // Match the current request
    $parameters = $matcher->match($request->getPathInfo());

    // Create a Request object with matched parameters
    $request = Request::createFromGlobals();
    $request->attributes->add($parameters);

    // Dispatch to controller/action
    $controller = $parameters['controller'];
    $controllerAction = explode('::', $controller);
    $controllerInstance = new $controllerAction[0]();
    // Pass the Request object
    $controllerInstance->{$controllerAction[1]}($request);
} catch (Exception $e) {
    echo 'HasMints - previously known as FamilyNFTs';
}
