<?php
require_once __DIR__ . '/../vendor/autoload.php';

$container = include __DIR__ . '/../src/container.php';
$db = $container['db'];

$db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, 'username' TEXT UNIQUE, 'password' TEXT);");

//$row = $db->exec("SELECT password from users WHERE id = 1");

$query = "SELECT * FROM users WHERE username = 'janschill'";
$stmt = $db->prepare($query);

$stmt->execute();
$row = $stmt->fetch(\PDO::FETCH_ASSOC);

var_dump($row);

// $db->exec("INSERT INTO users (username, password) VALUES ('janschill', $pw)");