<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

Use NewsSite\Core\Router;
Use NewsSite\Core\Renderer;

$routes = require_once '../routes.php';

$response = Router::response($routes);
$renderer = new Renderer();

echo $renderer->render($response);