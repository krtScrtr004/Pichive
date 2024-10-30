<?php
use Dotenv\Dotenv;

require_once '../../vendor/autoload.php'; // Adjust if needed

$dotenv = Dotenv::createImmutable('../../');
$dotenv->load();

