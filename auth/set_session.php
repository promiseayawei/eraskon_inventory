<?php
session_start();

// Get JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['first_name'])) {
    $_SESSION['first_name'] = $data['first_name'];
    $_SESSION['last_name'] = $data['last_name'];
    $_SESSION['role'] = $data['role'];

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Missing user data"]);
}
?>
