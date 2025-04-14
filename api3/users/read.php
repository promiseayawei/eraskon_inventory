<?php
include_once('userFunction.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {
    // Check if 'id' is provided
    if (isset($_GET['id'])) {
        $user = getUserById($_GET['id']);
        echo $user;
        die();
    }
    // Check if 'role' is provided
    else if (isset($_GET['role'])) {
        $getUserByRole = getUserByRole($_GET['role']);
        echo $getUserByRole;
        die();
    }
    // If no 'id' or 'role', return the user list
    $userList = getUserList();
    echo $userList;

} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
