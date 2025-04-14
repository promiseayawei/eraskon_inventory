<?php
// filepath: /Applications/XAMPP/xamppfiles/htdocs/KALPEP2/api3/partner/create/createPartner.php

// Include the partner function file
require_once('partnerFunction.php'); // Adjust the path to include the correct file

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $data = [
        'status' => 405,
        'message' => $_SERVER['REQUEST_METHOD'] . ' Method Not Allowed',
    ];
    header("Content-Type: application/json");
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
    exit;
}

// Extract form data
$userInput = [
    'short_name' => $_POST['short_name'] ?? null,
    'fullname' => $_POST['fullname'] ?? null,
    'address' => $_POST['address'] ?? null,
];

// Extract file input
$fileInput = [
    'logo' => $_FILES['logo'] ?? null,
];

// Call the createPartner function and output the result
echo createPartner($userInput, $fileInput);