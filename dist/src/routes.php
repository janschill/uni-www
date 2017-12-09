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
 * logout
 */
$routes->add(
  'logout',
  new Route(
    '/logout',
    ['_controller' => 'Controller\AdminController::logoutAction']
  )
);

/**
 * admin panel
 */
$routes->add(
  'admin',
  new Route(
    '/admin',
    ['_controller' => 'Controller\AdminLoginController::showFormAction']
  )
);
/**
 * admin blog
 */

$routes->add(
  'adminblognew',
  new Route(
    '/admin/blog/new',
    ['_controller' => 'Controller\AdminController::showFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

$routes->add(
  'adminblogdelete',
  new Route(
    '/admin/blog/delete/{id}',
    ['_controller' => 'Controller\AdminController::deleteBlogPost'],
    ['id' => '\d+'],
    ['_permission' => 'delete']
  )
);

$routes->add(
  'adminblogid',
  new Route(
    '/admin/blog/{id}',
    ['_controller' => 'Controller\AdminController::showBlog'],
    [],
    ['_permission' => 'edit']
  )
);

$routes->add(
  'adminblog',
  new Route(
    '/admin/blog',
    ['_controller' => 'Controller\AdminController::showBlog'],
    [],
    ['_permission' => 'edit']
  )
);


/**
 * admin project
 */
$routes->add(
  'adminprojectnew',
  new Route(
    '/admin/project/new',
    ['_controller' => 'Controller\AdminController::showBlog'],
    [],
    ['_permission' => 'edit']
  )
);

$routes->add(
  'adminprojectdelete',
  new Route(
    '/admin/project/delete',
    ['_controller' => 'Controller\AdminController::showBlog'],
    [],
    ['__permission' => 'edit']
  )
);

$routes->add(
  'adminproject',
  new Route(
    '/admin/project',
    ['_controller' => 'Controller\AdminController::showBlog'],
    [],
    ['_permission' => 'edit']
  )
);

$routes->add(
  'adminprojectid',
  new Route(
    '/admin/project/{id}',
    ['_controller' => 'Controller\AdminController::showBlog'],
    [],
    ['_permission' => 'edit']
  )
);


return $routes;
