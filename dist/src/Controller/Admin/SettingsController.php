<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Controller\Controller;

class SettingsController extends Controller
{
  public function showAdminSettingsAction($request)
  {
    $valid = false;
    $table = null;
    $form = null;
    $data = null;
    $parameters = $request->request->all();
    reset($parameters);

    switch (key($parameters)) {
      case 'tag':
        $table = 'tags';
        $form = 'tag';
        break;
      case 'category':
        $table = 'categories';
        $form = 'category';
        break;
    }

    if ($request->getMethod() === 'POST') {
      $data = $request->get($form);
      list($valid, $formError) = $this->isFormDataValid($table, $data);
    }

    if ($request->getMethod() === 'POST' && $valid) {
      $this->saveFormData($table, $data);
    }

    $user = $this->getAttributeFromRequest($request, 'user');
    $tags = $this->blogModel->getAllTags();
    $categories = $this->blogModel->getAllCategories();
    $users = $this->userModel->getAllUsers();
    $permissions = $this->userModel->getAllPermissions();
    $userpermissions = $this->userModel->getAllUsersPermissions();

    $html = $this->render('admin-settings.html.twig', array(
      'user' => $user,
      'tags' => $tags,
      'categories' => $categories,
      'users' => $users,
      'permissions' => $permissions,
      'userpermissions' => $userpermissions
    ));

    return new Response($html);
  }

  private function isFormDataValid($table, $data)
  {
    $valid = true;
    $formError = [];

    if (!isset($data) || $this->blogModel->getTableByName($table, $data) != null) {
      $valid = false;
      $formError[$data] = 'Invalid ' . $data . '.';
    }

    return [$valid, $formError];
  }

  private function saveFormData($table, $tag)
  {
    $this->blogModel->addTag($table, $tag);
  }

  public function deleteAdminSettingsTagAction($request)
  {
    $id = $this->getAttributeFromRequest($request, 'id');

    if (isset($id)) {
      if ($this->blogModel->deleteTag($id)) {
        return $this->redirect('/admin/settings', 302);
      }
    }
  }

}