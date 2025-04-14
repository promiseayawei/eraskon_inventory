<?php
// api for login POST REQUEST
require_once('./admin/adminFunction.php');
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "PUT") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $update_supervisor_user = update_supervisor_user($_POST);
    } else {
        $update_supervisor_user = update_supervisor_user($inputData);
    }
    echo $update_supervisor_user;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>