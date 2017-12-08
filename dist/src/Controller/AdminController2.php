<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller 
{
  private $model;

  public function __construct($container)
  {
    parent::__construct($container);
    $this->model = new \Model\BlogModel($this->container['db']);
  }

  public function showBlogForm($request) {
    $user = $request->attributes->get('user');
    $categories = $this->model->getAllCategories($request);
    $html = $this->container['twig']->render('config.html.twig', [
      'user' => $user,
      'categories' => $categories
    ]);
    return new Response($html);
  }
}