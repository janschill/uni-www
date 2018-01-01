<?php

namespace Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AboutController extends Controller
{

  public function __construct($container)
  {
    parent::__construct($container);
  }

  public function showAdminAction($request)
  {
    
    
    return new Response($html);
  }

}