<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{
  protected $formData, $blogModel, $userModel;

  public function __construct($container)
  {
    parent::__construct($container);
    $this->blogModel = new \Model\BlogModel($this->container['db']);
    $this->userModel = new \User\UserModel($this->container['db']);
  }

  /**
   * entry point for data form submission
   */
  public function showFormAction(Request $request)
  {
    $formData = [];
    $formError = [];
    $valid = false;
    $user = $request->attributes->get('user');
    $posts = [];
    $categories = $this->blogModel->getAllCategories($request);

    if($request->getMethod() == 'POST') {
      $formData = $request->get('form');
      list($valid, $formError) = $this->isFormDataValid($request, $formData);
    }

    if ($request->getMethod() == 'POST' && $valid) {
      $this->saveFormData($request, $formData);

      return new RedirectResponse('/admin');
    }
    
    // if($user->isAuthenticated()) {
    //   $posts = $this->model->getAllPosts();      
    // }

    $html = $this->container['twig']->render('adminblog.html.twig', [
      'form' => $formData, 
      'error' => $formError, 
      'user' => $user,
      'posts' => $posts,
      'categories' => $categories
      ]);

    return new Response($html);
  }

  protected function isFormDataValid(Request $request, $formData)
  {
    $valid = true;
    $formError = [];

    if((!isset($formData['title'])) || (!isset($formData['text']))) 
    {
      $valid = false;
      $formError['title'] = "Please fill out all input fields";
    }

    return [$valid, $formError];
  }

  /**
   */
  protected function saveFormData(Request $request, $formData)
  {
    var_dump($formData);
    $task['title'] = $formData['title'];
    $task['text'] = $formData['text'];
    
    if (date_default_timezone_get() != 'CET') {
      date_default_timezone_set('CET');
    }

    $task['date'] = date('m/d/Y h:i:s a', time());
    
    $user = $request->attributes->get('user');
    $id = $this->userModel->getUser($user->getUsername());  
    $task['author'] = $id['id'];

    $task['category'] = $formData['category'];

    var_dump($task);
    $this->blogModel->addPost($task);
  }

  // public function showBlog($request) {
  //   $categories = $this->model->getAllCategories($request);
  //   $html = $this->container['twig']->render('adminblog.html.twig',[
  //     // 'error' => $formError,
  //     // 'user' => $user,
  //     'categories' => $categories
  //   ]);
  //   return new Response($html);
  // }

}