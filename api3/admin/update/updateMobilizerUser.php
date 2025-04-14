<?php
// api for login POST REQUEST
require_once('./admin/adminFunction.php');
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "PUT") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $update_mobilizer_user = update_mobilizer_user($_POST);
    } else {
        $update_mobilizer_user = update_mobilizer_user($inputData);
    }
    echo $update_mobilizer_user;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>