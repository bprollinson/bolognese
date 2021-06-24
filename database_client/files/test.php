<?php

$host = 'database';
$db = 'webapp';
$user = 'root';
$password = '';

$pdo = new PDO("mysql:host={$host};dbname={$db}", $user, $password);
$statement = $pdo->prepare('SELECT COUNT(1) FROM entity');
$statement->execute();
echo $statement->fetchColumn() . "\n";
