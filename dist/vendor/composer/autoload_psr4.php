<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'User\\' => array($baseDir . '/src/User'),
    'Twig\\' => array($vendorDir . '/twig/twig/src'),
    'Symfony\\Polyfill\\Mbstring\\' => array($vendorDir . '/symfony/polyfill-mbstring'),
    'Symfony\\Component\\Routing\\' => array($vendorDir . '/symfony/routing'),
    'Symfony\\Component\\HttpKernel\\' => array($vendorDir . '/symfony/http-kernel'),
    'Symfony\\Component\\HttpFoundation\\' => array($vendorDir . '/symfony/http-foundation'),
    'Symfony\\Component\\EventDispatcher\\' => array($vendorDir . '/symfony/event-dispatcher'),
    'Symfony\\Component\\Debug\\' => array($vendorDir . '/symfony/debug'),
    'Service\\' => array($baseDir . '/src/Service'),
    'Psr\\Log\\' => array($vendorDir . '/psr/log/Psr/Log'),
    'Model\\' => array($baseDir . '/src/Model'),
    'Controller\\' => array($baseDir . '/src/Controller'),
    'Admin\\' => array($baseDir . '/src/Controller/Admin'),
);
