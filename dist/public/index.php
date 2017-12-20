<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Front\FrontController;

$container = include __DIR__ . '/../src/container.php';
$routes = include __DIR__ . '/../src/routes.php';

$ROOTPATH = __DIR__;
$container['root'] = $ROOTPATH;

$request = Request::createFromGlobals();

$session = $request->getSession();
if (!$session)
{
  $session = new Session();
}
$user = User\User::getFromSession($container, $session);
$request->attributes->set('user', $user);

$flash = $session->get('flash');
$request->attributes->set('flash', $flash);
$session->remove('flash');

$frontcontroller = new FrontController($request, $routes, $container);
$frontcontroller->run();

