<?php

namespace User;

use User\UserModel;
use Symfony\Component\HttpFoundation\Session\Session;

class User
{
  private $username;
  private $permissions;
  private $isAuthenticated;

  public function __construct()
  {
    $this->username = null;
    /* standard permissions for anon users */
    $this->permissions = $this->anonPermissions();
    $this->isAuthenticated = false;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function isAuthenticated()
  {
    return $this->isAuthenticated;
  }

  public function hasPermission($permissions)
  {
    return (array_search($permissions, $this->permissions) !== false);
  }

  /**
   *
   */
  static function getFromSession($container, Session $session)
  {
    $user = new User();
    $username = $session->get('username');
    if ($username) {
      $userModel = new UserModel($container['db']);
      $userData = $userModel->getUser($username);
      if ($userData) {
        $user->username = $username;
        $user->isAuthenticated = true;
        $user->permissions = $userModel->getPermissions($username);
      }
    }
    return $user;
  }

  private function anonPermissions()
  {
    return ['view'];
  }

  function logout($request)
  {
    $session = $request->getSession();
    if (!$session) {
      $session = new Session();
    }
    $session->remove('username');
    $this->username = null;
    $this->isAuthenticated = false;
    $this->permissions = $this->anonPermissions();
  }

}