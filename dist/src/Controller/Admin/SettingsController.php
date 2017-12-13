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

      if ($request->getMethod() === 'POST')
      {
        $formData = $request->get('form');
        list($valid, $formError) = $this->isFormDataValid($request, $formData);
      }
      
      if ($request->getMethod() === 'POST' && $valid)
      {
        $this->saveFormData($request, $formData);
      }
      
      
      
      $user = $this->getAttributeFromRequest($request, 'user');
      $tags = $this->blogModel->getAllTags();
      $categories = $this->blogModel->getAllCategories();

      $html = $this->render('admin-settings.html.twig', array(
        'user' => $user,
        'tags' => $tags,
        'categories' => $categories
      ));

      return new Response($html);
    }

    private function isFormDataValid($request, $formData)
    {

    }
    
    private function saveFormData($request, $formData)
    {
      
    }

}