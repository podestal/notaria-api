<!-- <?php
header("Content-Type: application/json");
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/login':
        require "../auth/login.php";
        break;
    case '/user':
        require "../users/get_user.php";
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
        break;
}
?> -->