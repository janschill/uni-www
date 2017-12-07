<?php 

namespace Controller;

class Controller 
{
  protected $container;

  public function __construct($container) {
    $this->container = $container;
  }
}