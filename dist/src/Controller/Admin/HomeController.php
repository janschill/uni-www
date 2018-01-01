<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Model\PostModel;
use User\UserModel;
use Controller\Controller;

class HomeController extends Controller
{

  public function __construct($container)
  {
    parent::__construct($container);
  }

  /* **************************** admin **************************** */
  public function showAdminHomeAction($request)
  {
    $blog = $this->postModel->getFewPosts('blog');
    $projects = $this->postModel->getFewPosts('projects');
    $user = $this->getAttributeFromRequest($request, 'user');
    
    $html = $this->render('admin.html.twig', array(
      'user' => $user,
      'blog' => $blog,
      'projects' => $projects
    ));

    return new Response($html);
  }
}