<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$container = include __DIR__ . '/../src/container.php';
$routes = include __DIR__ . '/../src/routes.php';

$request = Request::createFromGlobals();

$frontcontroller = new \App\FrontController($request, $routes, $container);
$frontcontroller->run();
