<?php

require_once 'load_env.php';

// Create a PDO instance
$pdo;
try {
    $dsn = 'mysql:host=' .  $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4';
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                  // deafult error mode to excaption
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);             // default fetch mode to associative array
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

