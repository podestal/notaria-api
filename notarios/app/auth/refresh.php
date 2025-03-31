<?php

header("Content-Type: application/json");

require __DIR__ . "/jwt_helper.php";
require __DIR__ . "/../core/response.php";

$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input["refresh_token"])) {
    respond_error("Missing refresh token", 400);
}

$decoded_refresh = validate_jwt($input["refresh_token"], "refresh");

if (!$decoded_refresh) {
    respond_error("Invalid or expired refresh token", 401);
}

// Generate a new access token
$user_data = (array) $decoded_refresh->data;
$new_access_token = generate_jwt($user_data, "access");

respond_success([
    "message" => "New access token generated",
    "access_token" => $new_access_token
]);
