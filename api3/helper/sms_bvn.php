<?php
// api for login POST REQUEST
include_once('bvn_initiate.php');
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $sms_bvn = sms_bvn($_POST);
    } else {
        $sms_bvn = sms_bvn($inputData);
    }
    echo $sms_bvn;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>