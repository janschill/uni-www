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
    ['_controller' => 'Controller\ViewController::showIndex']
    )
  );
$routes->add(
  'about',
  new Route(
    '/about',
    ['_controller' => 'Controller\ViewController::showAbout']
    )
  );
$routes->add(
  'projects',
  new Route(
    '/projects',
    ['_controller' => 'Controller\ViewController::showProjects']
    )
  );
$routes->add(
  'projectsID',
  new Route(
    '/projects/{id}',
    ['_controller' => 'Controller\ViewController::showProjects']
    )
  );
$routes->add(
  'blog',
  new Route(
    '/blog',
    ['_controller' => 'Controller\BlogController::showAllPosts']
    )
  );
$routes->add(
  'blogID',
  new Route(
    '/blog/{id}',
    ['_controller' => 'Controller\ViewController::showBlog']
    )
  );

/**
 * admin panel
 */
$routes->add(
  'admin',
  new Route(
    '/admin',
    ['_controller' => 'Controller\AdminController::showFormAction' ]
  )
);
$routes->add(
  'adminconf',
  new Route(
    '/admin/config',
    ['_controller' => 'Controller\AdminController::showBlogForm'], [], ['_permission' => 'add']
  )
);



return $routes;
