<?php
session_start();

$mono_secret_key = 'live_sk_t434z01lpijmabq27au5'; // Replace with your actual Mono secret key

header('Content-Type: application/json');

if (!isset($_SESSION['session_id'])) {
    echo json_encode([
        'status' => 401,
        'message' => 'Session not found.'
    ]);
    exit;
}

$session_id = $_SESSION['session_id'];
echo "Session ID: " . $session_id . "\n";
echo "Verification Methods:\n";

if (!isset($_GET['otp'])) {
    echo json_encode([
        'status' => 400,
        'message' => 'OTP not provided.'
    ]);
    exit;
}

$otp = $_GET['otp'];
$url = 'https://api.withmono.com/v2/lookup/bvn/details';
$payload = json_encode(['otp' => $otp]);

$headers = [
    'Content-Type: application/json',
    'mono-sec-key: ' . $mono_secret_key,
    'x-session-id: ' . $session_id
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200 && $response) {
    $decodedResponse = json_decode($response, true);

    echo json_encode([
        'status' => 200,
        'message' => $decodedResponse['message'] ?? 'BVN verification completed',
        'data' => $decodedResponse
    ]);
} else {
    echo json_encode([
        'status' => $httpCode,
        'message' => 'Verification failed',
        'data' => json_decode($response, true)
    ]);
}
