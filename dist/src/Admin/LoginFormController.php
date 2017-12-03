<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginFormController
{
  protected $container, $formData;

  public function __construct($container)
  {
    $this->container = $container;
    
    // really necessary??
    //$this->model = new \Admin\LoginFormModel($this->container['db']);
    // really necessary??

  }

  /**
   * entry point for data form submission
   */
  public function showFormAction(Request $request)
  {
    echo "showFormAction";
    $formData = [];
    $formError = [];
    $valid = false;

    if($request->getMethod() !== 'POST') {
      $formData = $this->getFormDefaults();
    } else {
      $formData = $request->get('form');
      list($valid, $formError) = $this->isLoginFormDataValid($request, $formData);
    }

    if ($request->getMethod() == 'POST' && $valid) {
      $this->saveFormData($request, $formData);

      return new RedirectResponse('/admin/conf');
    }

    $html = $this->container['twig']->render('admin.html.twig', ['form' => $formData, 'error' => $formError]);

    return new Response($html);
  }

  private function getFormDefaults()
  {
    $formData['username'] = 'janschill';
    return $formData;
  }

  /**
   * check if username/password is entered
   */
  protected function isLoginFormDataValid(Request $request, $formData)
  {
    $valid = true;
    $formError = [];

    if((!isset($formData['username']))) 
    {
      $valid = false;
      $formError['username'] = "Invalid username";
    }

    if((!isset($formData['password'])))
    {
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
    if(!$session) {
      $session = new Session();
    }

    $userModel = new \User\UserModel($this->container['db']);
    if($userModel->isValidUser($formData['username'], $formData['password']))
    {
      $session->set('username', $formData['username']);
    } else {
      $session->remove('username');
    } 
  }
}