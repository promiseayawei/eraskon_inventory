<?php
include_once('userFunction.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {
    if (isset($_GET['email'])) {
        $userProfile = getUserProfile($_GET);
        echo $user;
        die();
    
    } else {
        $data = [
            'status' => 400,
            'message' => 'Email parameter is required',
        ];
        header("HTTP/1.0 400 Bad Request");
        echo json_encode($data);
    }
} else {
    $data = [
        'status' => 405,
        'message' => "$requestMethod Method Not Allowed",
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
