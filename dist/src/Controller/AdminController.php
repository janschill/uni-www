<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{
  protected $formData, $blogModel, $userModel;

  public function __construct($container)
  {
    parent::__construct($container);
    $this->blogModel = new \Model\BlogModel($this->container['db']);
    $this->userModel = new \User\UserModel($this->container['db']);
  }

  /**
   * entry point for data form submission
   */
  public function showFormAction(Request $request)
  {
    $formData = [];
    $formError = [];
    $valid = false;

    if ($request->getMethod() !== 'POST') {
      $formData = $this->getFormDefaults();
    } else {
      $formData = $request->get('form');
      list($valid, $formError) = $this->isFormDataValid($request, $formData);
    }

    if ($request->getMethod() == 'POST' && $valid) {
      $this->saveFormData($request, $formData);

      return new RedirectResponse('/admin');
    }

    $user = $request->attributes->get('user');
    $categories = $this->blogModel->getAllCategories($request);

    $html = $this->container['twig']->render('adminblog.html.twig', [
      'form' => $formData,
      'error' => $formError,
      'user' => $user,
      'categories' => $categories,

    ]);

    return new Response($html);
  }

  protected function isFormDataValid(Request $request, $formData)
  {
    $valid = true;
    $formError = [];
    $token = $this->getToken();

    if ((!isset($formData['token'])) || (!hash_equals($token,
        $formData['token']))
    ) {
      $valid = false;
      $formError['token'] = 'Bad token';
      throw new \Exception('Bad CSRF token.');
    }

    if ((!isset($formData['title'])) || (strlen($formData['title']) < 3) || (!isset($formData['text']))) {
      $valid = false;
      $formError['title'] = "Please fill out all input fields";
    }

    return [$valid, $formError];
  }

  protected function getFormDefaults()
  {
    $formData['title'] = null;
    $formData['text'] = null;
    $formData['date'] = null;
    $formData['author'] = null;
    $formData['category'] = null;
    $formData['token'] = $this->getToken();

    return $formData;
  }

  private function getToken()
  {
    if ($this->is_session_started() === false) {
      //session_start();
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

  /**
   */
  protected function saveFormData(Request $request, $formData)
  {
    $task['title'] = $formData['title'];
    $task['text'] = $formData['text'];

    if (date_default_timezone_get() != 'CET') {
      date_default_timezone_set('CET');
    }

    $task['date'] = date('m/d/Y h:i:s a', time());

    $user = $request->attributes->get('user');
    $id = $this->userModel->getUser($user->getUsername());
    $task['author'] = $id['id'];

    $task['category'] = $formData['category'];

    $this->blogModel->addPost($task);
  }

  public function logoutAction($request)
  {
    $user = $request->attributes->get('user');
    $user->logout($request);
    return new RedirectResponse('/');
  }


  // public function showBlog($request) {
  //   $categories = $this->model->getAllCategories($request);
  //   $html = $this->container['twig']->render('adminblog.html.twig',[
  //     // 'error' => $formError,
  //     // 'user' => $user,
  //     'categories' => $categories
  //   ]);
  //   return new Response($html);
  // }

}