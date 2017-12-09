<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Model\BlogModel;

class BlogController extends Controller
{
  protected $model;

  public function __construct($container)
  {
    parent::__construct($container);
    $this->model = new BlogModel($this->container['db']);
  }

  public function showAllPosts($request)
  {
    $user = $request->attributes->get('user');
    $posts = $this->model->getAllPosts($request);
    $html = $this->container['twig']->render('blog.html.twig', [
      'posts' => $posts,
      'user' => $user,
    ]);
    return new Response($html);
  }
}