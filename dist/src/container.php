<?php

$loader = new \Twig_Loader_Filesystem(realpath(dirname(__FILE__)) . '/../templates');
$twig = new \Twig_Environment($loader, ['cache' => false, 'debug' => true]);

$db = null;

return ['twig' => $twig, 'db' => $db];
