<?php
// API for sign-up POST request
// include_once('helper/bvn_initiate.php');
include_once('helper/initiate_bvn_lookup.php');
// api for initiate_bvn_lookup POST REQUEST

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $initiate_bvn_lookup = initiate_bvn_lookup($_POST);
    } else {
        $initiate_bvn_lookup = initiate_bvn_lookup($inputData);
    }
    echo $initiate_bvn_lookup;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>
