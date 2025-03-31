<?php
// header("Content-Type: application/json");

// include __DIR__ . "/../config/database.php";
// require __DIR__ . "/jwt_helper.php";
// require __DIR__ . "/../core/response.php"; 

// $input = json_decode(file_get_contents("php://input"), true);

// if (!isset($input["usuario"]) || !isset($input["clave"])) {
//     respond_error("Missing username or password", 400);
// }

// $usuario = strtoupper($input["usuario"]);
// $password = strtoupper($input["clave"]);

// $sql = "SELECT * FROM usuarios WHERE loginusuario=?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $usuario);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($row = $result->fetch_assoc()) {
//     if ($row["password"] === $password && $row["estado"] == 1) {
//         $token = generate_jwt(["id" => $row["idusuario"], "usuario" => $row["loginusuario"]]);
//         respond_success(["message" => "Login successful", "token" => $token, "user" => ["id" => $row["idusuario"], "name" => $row["prinom"]]]);
//     } else {
//         respond_error("Invalid password or user blocked", 401);
//     }
// } else {
//     respond_error("User does not exist", 404);
// }

header("Content-Type: application/json");

include __DIR__ . "/../config/database.php";
require __DIR__ . "/jwt_helper.php";
require __DIR__ . "/../core/response.php"; 

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input["usuario"]) || !isset($input["clave"])) {
    respond_error("Missing username or password", 400);
}

$usuario = strtoupper($input["usuario"]);
$password = strtoupper($input["clave"]);

$sql = "SELECT * FROM usuarios WHERE loginusuario=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if ($row["password"] === $password && $row["estado"] == 1) {
        // Generate tokens
        $user_data = ["id" => $row["idusuario"], "usuario" => $row["loginusuario"]];
        $access_token = generate_jwt($user_data, "access");
        $refresh_token = generate_jwt($user_data, "refresh");

        respond_success([
            "message" => "Login successful",
            "access_token" => $access_token,
            "refresh_token" => $refresh_token,
            "user" => ["id" => $row["idusuario"], "name" => $row["prinom"]]
        ]);
    } else {
        respond_error("Invalid password or user blocked", 401);
    }
} else {
    respond_error("User does not exist", 404);
}

?>
