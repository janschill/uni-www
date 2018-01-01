<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;

interface FormInterface
{

  function __construct($container);

  function showFormAction(Request $request);

  function isFormDataValid(Request $request, $formData);

  function getFormDefaults($request, $instance, $id);

  function saveFormData(Request $request, $instance, $formData, $id);

  function showAdminAction($request);
}