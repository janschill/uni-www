<?php 

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller 
{
  protected $container;

  public function __construct($container) {
    $this->container = $container;
  }
}