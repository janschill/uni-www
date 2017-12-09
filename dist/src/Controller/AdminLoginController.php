<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminLoginController extends Controller
{
  protected $formData;

  public function __construct($container)
  {
    parent::__construct($container);
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

    if ($request->getMethod() == 'POST') {
      $formData = $request->get('form');
      list($valid, $formError) = $this->isLoginFormDataValid($request, $formData);
    }

    if ($request->getMethod() == 'POST' && $valid) {
      $this->saveFormData($request, $formData);

      return new RedirectResponse('/admin');
    }

    if ($user->isAuthenticated()) {
      $posts = $this->getBlogPosts();
    }

    $html = $this->container['twig']->render('admin.html.twig', [
      'form' => $formData,
      'error' => $formError,
      'user' => $user,
      'posts' => $posts
    ]);

    return new Response($html);
  }

  /**
   * check if username/password is entered
   */
  protected function isLoginFormDataValid(Request $request, $formData)
  {
    $valid = true;
    $formError = [];

    if ((!isset($formData['username']))) {
      $valid = false;
      $formError['username'] = "Invalid username";
    }

    if ((!isset($formData['password']))) {
      $valid = false;
      $formError['password'] = "Invalid password";
    }

    return [$valid, $formError];
  }

  /**
   * put username/password into session, also check if combo is valid
   */
  protected function saveFormData(Request $request, $formData)
  {
    $session = $request->getSession();
    if (!$session) {
      $session = new Session();
    }

    $userModel = new \User\UserModel($this->container['db']);
    if ($userModel->isValidUser($formData['username'], $formData['password'])) {
      $session->set('username', $formData['username']);
    } else {
      $session->remove('username');
    }
  }

  private function getBlogPosts()
  {
    $model = new \Model\BlogModel($this->container['db']);
    return $model->getAllPosts();
  }
}