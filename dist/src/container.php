<?php

$loader = new \Twig_Loader_Filesystem(realpath(dirname(__FILE__)) . '/../templates');
$twig = new \Twig_Environment($loader, ['cache' => false, 'debug' => true]);

$db = new \PDO('sqlite:' . realpath(dirname(__FILE__)) . '/../data/website.db');
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

return ['twig' => $twig, 'db' => $db];
