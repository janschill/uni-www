<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Model\BlogModel;
use Model\ProjectModel;
use User\UserModel;

class Controller
{
  protected $container;
  protected $blogModel, $userModel, $projectModel;
  protected $root;

  public function __construct($container)
  {
    $this->container = $container;
    $this->blogModel = new BlogModel($this->container['db']);
    $this->userModel = new UserModel($this->container['db']);
    $this->projectModel = new ProjectModel($this->container['db']);    
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

  public function getUserFromRequest($request)
  {
    return $request->attributes->get('user');
  }

  public function getToken()
  {
    if ($this->is_session_started() === false) {
    }
    if (empty($_SESSION['token'])) {
      if (function_exists('random_bytes')) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
      } else {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
      }
    }
    $token = $_SESSION['token'];

    return $token;
  }

  private function is_session_started()
  {
    if (php_sapi_name() !== 'cli') {
      if (version_compare(phpversion(), '5.4.0', '>=')) {
        return session_status() === PHP_SESSION_ACTIVE ? true : false;
      } else {
        return session_id() === '' ? false : true;
      }
    }
    return false;
  }
}