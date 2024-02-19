<?php
define('DB_DSN', 'mysql:host=localhost;dbname=stes');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

try {
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}

