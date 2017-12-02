<?php
require_once __DIR__ . '/../vendor/autoload.php';

$container = include __DIR__ . '/../src/container.php';
$db = $container['db'];

$db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, 'username' TEXT UNIQUE, 'password' TEXT);");