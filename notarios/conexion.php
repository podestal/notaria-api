<?php
$ip      = 'db'; // Use the service name 'db' from docker-compose.yml
$user    = 'root';
$contra  = 'root';
$db_name = 'notarios';

// Create connection using MySQLi
$conn = new mysqli($ip, $user, $contra, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8 (optional, recommended)
$conn->set_charset("utf8");

?>
