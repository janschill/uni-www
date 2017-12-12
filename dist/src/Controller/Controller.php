<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Controller
{
  protected $container;

  public function __construct($container)
  {
    $this->container = $container;
  }

  public function redirect($url, $code)
  {
    return new RedirectResponse($url, $code);
  }

  public function render($template, $parameters)
  {
    return $this->container['twig']->render($template, $parameters);
  }
}