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

/* **************************** login/logout **************************** */
$routes->add(
  'logout',
  new Route(
    '/logout',
    ['_controller' => 'Controller\LoginController::logoutAction']
  )
);

$routes->add(
  'login',
  new Route(
    '/login',
    ['_controller' => 'Controller\LoginController::loginAction']
  )
);

$routes->add(
  'signup',
  new Route(
    '/signup',
    ['_controller' => 'Controller\SignUpController::signUpAction']
  )
);

/* **************************** admin **************************** */
$routes->add(
  'admin',
  new Route(
    '/admin',
    ['_controller' => 'Admin\HomeController::showAdminHomeAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin **************************** */
$routes->add(
  'adminabout',
  new Route(
    '/admin/about',
    ['_controller' => 'Admin\AboutController::showAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / blog / new **************************** */
$routes->add(
  'adminblognew',
  new Route(
    '/admin/blog/new',
    ['_controller' => 'Admin\PostController::showFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / blog / delete **************************** */
$routes->add(
  'adminblogdelete',
  new Route(
    '/admin/blog/delete/{id}',
    ['_controller' => 'Admin\PostController::deleteAdminAction'],
    ['id' => '\d+'],
    ['_permission' => 'delete']
  )
);

/* **************************** admin / blog / edit **************************** */
$routes->add(
  'adminblogid',
  new Route(
    '/admin/blog/edit/{id}',
    ['_controller' => 'Admin\PostController::showFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / blog / author **************************** */
$routes->add(
  'adminblogauthor',
  new Route(
    '/admin/blog/{author}',
    ['_controller' => 'Admin\PostController::showAction'],
    ['_permission' => 'edit']
  )
);


/* **************************** admin / blog **************************** */
$routes->add(
  'adminblog',
  new Route(
    '/admin/blog',
    ['_controller' => 'Admin\PostController::showAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / project / new **************************** */
$routes->add(
  'adminprojectnew',
  new Route(
    '/admin/projects/new',
    ['_controller' => 'Admin\PostController::showFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / project / delete **************************** */
$routes->add(
  'adminprojectdelete',
  new Route(
    '/admin/projects/delete/{id}',
    ['_controller' => 'Admin\PostController::deleteAdminAction'],
    ['id' => '\d+'],
    ['_permission' => 'delete']
  )
);

/* **************************** admin / project / edit **************************** */
$routes->add(
  'adminprojectid',
  new Route(
    '/admin/projects/edit/{id}',
    ['_controller' => 'Admin\PostController::showFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / blog / author **************************** */
$routes->add(
  'adminprojectsauthor',
  new Route(
    '/admin/projects/{author}',
    ['_controller' => 'Admin\PostController::showAction'],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / project **************************** */
$routes->add(
  'adminproject',
  new Route(
    '/admin/projects',
    ['_controller' => 'Admin\PostController::showAction'],
    [],
    ['_permission' => 'edit']
  )
);


/* **************************** admin / media / new **************************** */
$routes->add(
  'medianew',
  new Route(
    '/admin/media/new',
    ['_controller' => 'Admin\MediaController::showAdminMediaFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / media / delete **************************** */
$routes->add(
  'adminmediadelete',
  new Route(
    '/admin/media/delete/{id}',
    ['_controller' => 'Admin\MediaController::showBlog'],
    ['id' => '\d+'],
    ['_permission' => 'delete']
  )
);

/* **************************** admin / media **************************** */
$routes->add(
  'media',
  new Route(
    '/admin/media',
    ['_controller' => 'Admin\MediaController::showAdminMediaFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / settings **************************** */
$routes->add(
  'adminsettingstagdelete',
  new Route(
    '/admin/settings/tag/delete/{id}',
    ['_controller' => 'Admin\SettingsController::deleteAdminSettingsTagAction'],
    ['id' => '\d+'],
    ['_permission' => 'delete']
  )
);

$routes->add(
  'adminsettings',
  new Route(
    '/admin/settings',
    ['_controller' => 'Admin\SettingsController::showAdminSettingsAction'],
    [],
    ['_permission' => 'edit']
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
    ['_controller' => 'Controller\ViewController::showPosts']
  )
);

$routes->add(
  'projectsID',
  new Route(
    '/projects/{id}',
    ['_controller' => 'Controller\ViewController::showSinglePost'],
    ['id' => '\d+']
  )
);
$routes->add(
  'blog',
  new Route(
    '/blog',
    ['_controller' => 'Controller\ViewController::showPosts']
  )
);

$routes->add(
  'blogID',
  new Route(
    '/blog/{id}',
    ['_controller' => 'Controller\ViewController::showSinglePost'],
    ['id' => '\d+']
  )
);

$routes->add(
  'blogComment',
  new Route(
    '/blog/{id}/new',
    ['_controller' => 'Controller\CommentController::showFormAction'],
    ['id' => '\d+'],
    ['_permission' => 'add']
  )
);

$routes->add(
  'documentation',
  new Route(
    '/documentation',
    ['_controller' => 'Controller\DocumentationController::showAction'],
    ['id' => '\d+'],
    ['_permission' => 'add']
  )
);

$routes->add(
  'impressum',
  new Route(
    '/impressum',
    ['_controller' => 'Controller\ViewController::showImpressum'],
    ['id' => '\d+'],
    ['_permission' => 'add']
  )
);

$routes->add(
  'removetrailingslash',
  new Route(
    '/{url}',
    array(
      '_controller' => 'Helper\RedirectingController::removeTrailingSlash',
    ),
    array(
      'url' => '.*/$',
    ),
    array(),
    '',
    array(),
    array('GET')
  )
);


return $routes;
