<?php

namespace Controller;

use Symfony\Componnent\HttpFoundation\Request;
use Symfony\Componnent\HttpFoundation\Response;

class BlogController extends \Controller\Controller
{
  public function __construct($container) {
    parent::__construct($container);
    $this->model = new \Model\BlogModel($this->container);    
  }

  public function showAllPosts($request) {
    $user = $request->attributes->get('user');
    $posts = $this->model->getAllPosts($request);
    $html = $this->container['twig']->render('blog.html.twig', [
      'posts' => $posts,
      'user' => $user,
      ]);
    return new Response($html);
  }
}