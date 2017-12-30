<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;

interface PostsInterface
{

  function __construct($container);

  function showFormAction(Request $request);

  function isFormDataValid(Request $request, $formData);

  function getFormDefaults($request, $edit, $id);

  function saveFormData(Request $request, $formData, $id);

  function showAdminAction($request);
}