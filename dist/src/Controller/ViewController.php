<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Service\PathChecker;

class ViewController extends FormController
{
  public function __construct($container)
  {
    parent::__construct($container);
  }

  public function showIndex($request)
  {
    $user = $request->attributes->get('user');
    $html = $this->container['twig']->render('index.html.twig', ['user' => $user]);
    return new Response($html);
  }

  public function showAbout($request)
  {
    $user = $request->attributes->get('user');
    $html = $this->container['twig']->render('about.html.twig', ['user' => $user]);
    return new Response($html);
  }

  public function showProjects($request)
  {
    $user = $request->attributes->get('user');
    $id = $request->attributes->get('id');


  }

  public function showPosts($request)
  {
    $user = $request->attributes->get('user');
    $route = $this->getAttributeFromRequest($request, '_route');
    $instance = PathChecker::checkPath($route);
    $posts = $this->postModel->getAllPosts($instance['instance']);
    $categories = $this->postModel->getAllCategories();
    $tags = $this->postModel->getAllTags();

    $html = $this->render($instance['html'], [
      'posts' => $posts,
      'user' => $user,
      'tags' => $tags,
      'categories' => $categories,
      'instance' => $instance
    ]);
    return new Response($html);
  }

  public function showSinglePost($request)
  {
    $id = $this->getAttributeFromRequest($request, 'id');
    $user = $request->attributes->get('user');
    $route = $this->getAttributeFromRequest($request, '_route');
    $instance = PathChecker::checkPath($route);
    $post = $this->postModel->getOnePost($instance['instance'], $id);
    $categories = $this->postModel->getAllCategories();
    $tags = $this->postModel->getAllTags();
    $comments = $this->postModel->getAllCommentsForPost($id);
    $form['token'] = $this->getToken();

    $html = $this->render($instance['html'], [
      'id' => $id,
      'post' => $post,
      'user' => $user,
      'tags' => $tags,
      'categories' => $categories,
      'instance' => $instance,
      'comments' => $comments,
      'form' => $form
    ]);
    return new Response($html);
  }

  public function showConf($request)
  {
    $user = $request->attributes->get('user');
    $categories = $request->attributes->get('categories');
    $html = $this->container['twig']->render('conf.html.twig', [
      'user' => $user,
      'categories' => $categories
    ]);
    return new Response($html);
  }
}
