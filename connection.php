<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration from environment variables
$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'ccti_1';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

ini_set('display_errors', 1); //1 for development, 0 for production
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/connerror.log');

try {
    // Create MySQLi connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    // Set charset for security and proper encoding
    if (!$conn->set_charset($charset)) {
        throw new Exception('Error setting charset: ' . $conn->error);
    }

    // Optional: Set MySQLi options
    $conn->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

} catch (Exception $e) {
    // Log error and return generic message
    error_log('Connection error: ' . $e->getMessage());
    http_response_code(500);
    die(json_encode(['success' => false, 'message' => 'Internal server error. Please try again later.']));
}