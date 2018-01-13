<?php 

namespace Controller;

class CommentController extends FormController
{
  protected $formData;

  function __construct($container)
  {
    parent::__construct($container);
  }

  function showFormAction($request) 
  {
    $formData = [];
    $formError = [];
    $valid = false;
    $route = $this->getAttributeFromRequest($request, '_route');
    $id = $this->getAttributeFromRequest($request, 'id');
    $user = $this->getAttributeFromRequest($request, 'user');

    if ($request->getMethod() !== 'POST') {
      $formData = $this->getFormDefaults($request, $user);
      var_dump($formData);die();
    } else {
      $formData = $request->get('form');
      list($valid, $formError) = $this->isFormDataValid($request, $formData);
    }

    if ($request->getMethod() == 'POST' && $valid) {
      $this->saveFormData($request, $formData, $id);

      return $this->redirect('/blog/' . $id, 302);
    }

    $html = $this->render($instance['html'], [
      'form' => $formData,
      'error' => $formError,
      'user' => $user
    ]);

    return new Response($html);
  }

  function isFormDataValid($request, $formData)
  {
    $valid = true;
    $formError = [];
    $token = $this->getToken();

    var_dump($formData);
    var_dump($formData['token']);

    if ((!isset($formData['token'])) || (!hash_equals($token,
        $formData['token']))
    ) {
      $valid = false;
      $formError['token'] = 'Bad token';
      throw new \Exception('Bad CSRF token.');
    }

    if ((!isset($formData['author'])) || (!isset($formData['text']))) {
      $valid = false;
      $formError['author'] = "Please fill out all fields";
    }

    return [$valid, $formError];
  }

  function getFormDefaults($request, $user)
  {  
    $formData['token'] = $this->getToken();

    if (!is_null($user))
    {
      $formData['admin'] = $this->userModel->getUserId($user['username']);
    }

    return $formData;
  }

  function saveFormData($request, $formData, $id)
  {
    $this->postModel->addComment($formData, $id);
  }

  function showAction($request){}

}