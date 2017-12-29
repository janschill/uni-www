<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Model\BlogModel;

class BlogController extends Controller
{
  public function __construct($container)
  {
    parent::__construct($container);
  }

  public function showAllPosts($request)
  {
    $user = $request->attributes->get('user');
    $posts = $this->blogModel->getAllPosts($request);
    $categories = $this->blogModel->getAllCategories();
    $tags = $this->blogModel->getAllTags();
    $html = $this->container['twig']->render('blog.html.twig', [
      'posts' => $posts,
      'user' => $user,
      'tags' => $tags,
      'categories' => $categories
    ]);
    return new Response($html);
  }
}