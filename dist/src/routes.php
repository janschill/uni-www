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
    ['_controller' => 'Controller\AdminController::logoutAction']
  )
);

$routes->add(
  'login',
  new Route(
    '/login',
    ['_controller' => 'Controller\LoginController::showFormAction']
  )
);



/* **************************** admin **************************** */
$routes->add(
  'admin',
  new Route(
    '/admin',
    ['_controller' => 'Controller\AdminController::showAdminAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / blog / new **************************** */
$routes->add(
  'adminblognew',
  new Route(
    '/admin/blog/new',
    ['_controller' => 'Controller\AdminController::showFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / blog / delete **************************** */
$routes->add(
  'adminblogdelete',
  new Route(
    '/admin/blog/delete/{id}',
    ['_controller' => 'Controller\AdminController::deleteAdminBlogAction'],
    ['id' => '\d+'],
    ['_permission' => 'delete']
  )
);

/* **************************** admin / blog / edit **************************** */
$routes->add(
  'adminblogid',
  new Route(
    '/admin/blog/edit/{id}',
    ['_controller' => 'Controller\AdminController::showFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / blog **************************** */
$routes->add(
  'adminblog',
  new Route(
    '/admin/blog',
    ['_controller' => 'Controller\AdminController::showAdminBlogAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / project / new **************************** */
$routes->add(
  'adminprojectnew',
  new Route(
    '/admin/project/new',
    ['_controller' => 'Controller\AdminController::showBlog'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / project / delete **************************** */
$routes->add(
  'adminprojectdelete',
  new Route(
    '/admin/project/delete/{id}',
    ['_controller' => 'Controller\AdminController::showBlog'],
    ['id' => '\d+'],
    ['_permission' => 'delete']
  )
);

/* **************************** admin / project / edit **************************** */
$routes->add(
  'adminprojectid',
  new Route(
    '/admin/project/edit/{id}',
    ['_controller' => 'Controller\AdminController::showBlog'],
    [],
    ['_permission' => 'edit']
    )
  );
  
/* **************************** admin / project **************************** */
$routes->add(
  'adminproject',
  new Route(
    '/admin/project',
    ['_controller' => 'Controller\AdminController::showAdminProjectsAction'],
    [],
    ['_permission' => 'edit']
  )
);


/* **************************** admin / media / new **************************** */
$routes->add(
  'medianew',
  new Route(
    '/admin/media/new',
    ['_controller' => 'Controller\AdminController::showAdminMediaFormAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / media / delete **************************** */
$routes->add(
  'adminmediadelete',
  new Route(
    '/admin/media/delete/{id}',
    ['_controller' => 'Controller\AdminController::showBlog'],
    ['id' => '\d+'],
    ['_permission' => 'delete']
  )
);

/* **************************** admin / media **************************** */
$routes->add(
  'media',
  new Route(
    '/admin/media',
    ['_controller' => 'Controller\AdminController::showAdminMediaAction'],
    [],
    ['_permission' => 'edit']
  )
);

/* **************************** admin / settings **************************** */
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


$routes->add(
  'removetrailingslash',
  new Route(
    '/{url}',
    array(
      '_controller' => 'Controller\RedirectingController::removeTrailingSlash',
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
