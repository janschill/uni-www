<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add(
  'default',
  new Route(
    '/',
    ['_controller' => 'App\Controller::showIndex']
    )
  );
$routes->add(
  'about',
  new Route(
    '/about',
    ['_controller' => 'App\Controller::showAbout']
    )
  );
$routes->add(
  'projects',
  new Route(
    '/projects',
    ['_controller' => 'App\Controller::showProjects']
    )
  );
$routes->add(
  'projectsID',
  new Route(
    '/projects/{id}',
    ['_controller' => 'App\Controller::showProjects']
    )
  );
$routes->add(
  'blog',
  new Route(
    '/blog',
    ['_controller' => 'App\Controller::showBlog']
    )
  );


return $routes;
