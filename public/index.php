<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use NewsSite\Core\Container;
use NewsSite\Core\Renderer;
use NewsSite\Core\Router;

$container = new Container();
$router = new Router($container);
$routes = require_once '../routes.php';

$response = $router->response($routes);
$renderer = new Renderer();

echo $renderer->render($response);