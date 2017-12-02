<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

/**
 * main page routes
 */
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
$routes->add(
  'blogID',
  new Route(
    '/blog/{id}',
    ['_controller' => 'App\Controller::showBlog']
    )
  );

/**
 * admin panel
 */
$routes->add(
  'admin',
  new Route(
    '/admin',
    ['_controller' => 'App\Controller::showAdmin' ]
  )
);




return $routes;
