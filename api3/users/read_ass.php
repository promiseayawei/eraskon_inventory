<?php
include_once('userFunction.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {

    if (isset($_GET['id'])) {
        $userAss = getUserAss($_GET);
        echo $userAss;
        die();
    }else if (isset($_GET['role'])) {
        $getUserByRoleAss = getUserByRoleAss($_GET);
        echo $getUserByRoleAss;
        die();
    } 

    $userListAss = getUserListAss();
    echo $userListAss;
    
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
