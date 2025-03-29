<?php
$ip      = getenv('DATABASE_HOST');
$user    = getenv('DATABASE_USER'); 
$contra  = getenv('DATABASE_PASSWORD');
$db_name = getenv('DATABASE_NAME'); 

// Create connection using MySQLi
$conn = new mysqli($ip, $user, $contra, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8 (optional, recommended)
$conn->set_charset("utf8");

?>
