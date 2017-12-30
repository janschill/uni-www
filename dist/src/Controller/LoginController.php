<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use User\UserModel;

class LoginController extends Controller
{
  protected $formData;

  public function __construct($container)
  {
    parent::__construct($container);
  }

  /**
   * entry point for data form submission
   */
  public function loginAction(Request $request)
  {
    $formData = [];
    $formError = [];
    $valid = false;

    if ($request->getMethod() == 'POST') {
      $formData = $request->get('form');
      list($valid, $formError) = $this->isLoginFormDataValid($request, $formData);
    }

    if ($request->getMethod() == 'POST' && $valid) {
      $this->saveFormData($request, $formData);

      return new RedirectResponse('/admin');
    }

    $html = $this->container['twig']->render('login.html.twig', [
      'form' => $formData,
      'error' => $formError,
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

    $userModel = new UserModel($this->container['db']);
    if ($userModel->isValidUser($formData['username'], $formData['password'])) {
      $session->set('username', $formData['username']);
    } else {
      $session->remove('username');
    }
  }

  /* **************************** logout **************************** */
  public function logoutAction($request)
  {
    $user = $this->getAttributeFromRequest($request, 'user');
    $user->logout($request);
    return $this->redirect('/', 302);
  }
}