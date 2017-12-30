<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Model\BlogModel;
use User\UserModel;
use Controller\Controller;

class ProjectsController extends Controller implements PostsInterface
{
  protected $formData;

  public function __construct($container)
  {
    parent::__construct($container);
  } 
 
  public function showFormAction(Request $request)
  {

  }


  public function isFormDataValid(Request $request, $formData)
  {

  }

  public function getFormDefaults($request, $edit, $id)
  {

  }

  public function saveFormData(Request $request, $formData, $id)
  {

  }

  public function showAdminAction($request)
  {
    $user = $this->getAttributeFromRequest($request, 'user');
    $posts = $this->projectModel->getAllPosts();
    $html = $this->render('admin-projects.html.twig', [
      'posts' => $posts,
      'user' => $user
    ]);

    return new Response($html);
  }

}