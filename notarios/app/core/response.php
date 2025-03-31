<?php
function respond_success($data, $status_code = 200) {
    http_response_code($status_code);
    echo json_encode($data);
    exit;
}

function respond_error($message, $status_code = 400) {
    http_response_code($status_code);
    echo json_encode(["error" => $message]);
    exit;
}
?>