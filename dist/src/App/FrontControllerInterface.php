<?php

namespace App;

interface FrontControllerInterface {
  
  function __construct($request, $routes, $container);

  function setControllerAction($request);
  
  function callAction($method);
  
  function run();
}