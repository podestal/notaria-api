<?php
require "../auth/jwt_helper.php";
require "../core/response.php";
$headers = getallheaders();
if (!isset($headers["Authorization"])) {
    respond_error("Unauthorized", 401);
}
$token = str_replace("Bearer ", "", $headers["Authorization"]);
$decoded = validate_jwt($token);
if (!$decoded) {
    respond_error("Invalid token", 401);
}
?>