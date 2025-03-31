<?php
// require 'vendor/autoload.php';
// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

// $SECRET_KEY = "your_secret_key"; // Replace with a strong secret key

// function generate_jwt($payload) {
//     global $SECRET_KEY;
//     return JWT::encode($payload, $SECRET_KEY, 'HS256');
// }

// function validate_jwt($token) {
//     global $SECRET_KEY;
//     try {
//         return JWT::decode($token, new Key($SECRET_KEY, 'HS256'));
//     } catch (Exception $e) {
//         return null;
//     }
// }

require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$SECRET_KEY = "your_secret_key";  // Replace with a strong secret key
$REFRESH_SECRET_KEY = "your_refresh_secret_key";  // Another strong key

function generate_jwt($payload, $type = 'access') {
    global $SECRET_KEY, $REFRESH_SECRET_KEY;

    $issued_at = time();
    $expiration_time = ($type === 'access') ? $issued_at + 900 : $issued_at + 604800; // 15 min for access, 7 days for refresh

    $token_payload = [
        "iat" => $issued_at,    // Issued at time
        "exp" => $expiration_time, // Expiration time
        "data" => $payload      // User data
    ];

    $secret = ($type === 'access') ? $SECRET_KEY : $REFRESH_SECRET_KEY;
    return JWT::encode($token_payload, $secret, 'HS256');
}

function validate_jwt($token, $type = 'access') {
    global $SECRET_KEY, $REFRESH_SECRET_KEY;

    try {
        $secret = ($type === 'access') ? $SECRET_KEY : $REFRESH_SECRET_KEY;
        return JWT::decode($token, new Key($secret, 'HS256'));
    } catch (Exception $e) {
        return null;
    }
}

?>

