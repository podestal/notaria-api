<?php
$ip      = getenv('DATABASE_HOST');
$user    = getenv('DATABASE_USER'); 
$contra  = getenv('DATABASE_PASSWORD');
$db_name = getenv('DATABASE_NAME'); 

// Create connection using MySQLi
$conn = new mysqli($ip, $user, $contra, $db_name);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}
$conn->set_charset("utf8");
?>