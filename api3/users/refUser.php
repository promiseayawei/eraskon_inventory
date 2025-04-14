<?php
include_once('userFunction.php');

// Log the incoming request to debug
file_put_contents('php://stderr', "Referral endpoint accessed\n");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {
    if (isset($_GET['referral'])) {
        $referral_id = $_GET['referral'];
        file_put_contents('php://stderr', "Referral ID: $referral_id\n"); // Log referral ID

        // Call the refUserById function
        $user = refUserById($referral_id);
        echo $user;
        die();
    } else {
        $data = [
            'status' => 422,
            'message' => 'Referral ID is required',
        ];
        header("HTTP/1.0 422 Unprocessable Entity");
        echo json_encode($data);
        die();
    }
} else {
    $data = [
        'status' => 405,
        'message' => 'Method Not Allowed. Only GET is allowed.',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
    die();
}
