<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Model\BlogModel;
use User\UserModel;

class Controller
{
  protected $container;
  protected $blogModel, $userModel;
  protected $root;

  public function __construct($container)
  {
    $this->container = $container;
    $this->blogModel = new BlogModel($this->container['db']);
    $this->userModel = new UserModel($this->container['db']);
    $this->root = $this->container['root'];
  }

  public function redirect($url, $code)
  {
    return new RedirectResponse($url, $code);
  }

  public function render($template, $parameters)
  {
    return $this->container['twig']->render($template, $parameters);
  }

  public function getAttributeFromRequest($request, $string)
  {
    return $request->attributes->get($string);
  }
}