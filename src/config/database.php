<?php

// Move this into an .env file
define('DB_HOST', 'localhost');
define('DB_NAME', 'PICHIVE');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create a PDO instance
$pdo;
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                  // deafult error mode to excaption
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);             // default fetch mode to associative array
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

