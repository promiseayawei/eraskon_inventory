<?php
include_once('recordFunction.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {

    if (isset($_GET['id'])) {
        $records = getRecord($_GET);
        echo $records;
        die();
    }else if (isset($_GET['role'])) {
        $getRecordByRole = getRecordByRole($_GET);
        echo $getRecordByRole;
        die();
    } 

    $userList = getRecordList();
    echo $userList;
    
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
