<?php

$response = false;  // Initialize the response as false

// Utility function to validate BVN
function isValidBVN($bvn) {
    $bvn = preg_replace('/[^0-9]/', '', $bvn);
    return strlen($bvn) === 11;
}

// Utility function to fetch data from the database
function fetchData($conn, $query) {
    $result = $conn->query($query);
    return $result->num_rows > 0 ? $result->fetch_assoc() : null;
}

// Utility function to update agent account
function updateAgentAccount($conn, $verificationCode, $bvn, $nin, $extra, $agentId) {
    $stmt = $conn->prepare("UPDATE agent_accounts SET otp = ?, bvn = ?, nin = ?, extra = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $verificationCode, $bvn, $nin, $extra, $agentId);
    return $stmt->execute();
}

// Utility function to insert BVN records
function insertBVNRecord($conn, $table, $userId, $source, $bvn, $data, $status = null, $phoneNumber = null) {
    $stmt = $conn->prepare("INSERT INTO `$table` (user_id, source, bvn, data, status, phone_number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $userId, $source, $bvn, $data, $status, $phoneNumber);
    $stmt->execute();
}

// Utility function to send verification SMS
function sendVerificationSMS($phoneNumber, $verificationCode) {
    $message = "Your enetworksPay BVN authentication code is: $verificationCode. Do not share this with anyone.";
    return send_message($phoneNumber, 2, $message, "ENETWORKS");
}

if (!isset($_POST['bvn']) || !isValidBVN($_POST['bvn'])) {
    echo json_encode(['status' => false, 'message' => 'Invalid BVN. Please enter a valid 11-digit BVN.']);
    exit;
}

$bvn = ($_POST['bvn']);
$nin = ($_POST['nin']);
$agentId = $_SESSION['agent_id'];

// Step 1: Check local BVN database
$row = fetchData($conn, "SELECT `user_id`, `source`, `bvn`, `data` FROM dumps_bvn WHERE bvn = '$bvn' LIMIT 1");
if ($row) {
    $jsonData = json_decode($row['data'], true);
    $verificationCode = rand(1000, 9999);

    if (updateAgentAccount($conn, $verificationCode, '', $nin, $row['data'], $agentId) && sendVerificationSMS($jsonData['phone'], $verificationCode)) {
        echo json_encode(['status' => true, 'message' => $jsonData['phone'], 'bvn' => $bvn]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to send verification code.']);
    }
    exit;
}

// Step 2: Check failed BVN database
$sources = ['1app', 'mono'];
$failedBVN = null;
foreach ($sources as $source) {
    $failedBVN = fetchData($conn, "SELECT `data` FROM dumps_bvn_failed WHERE bvn = '$bvn' AND source = '$source' LIMIT 1");
    if ($failedBVN) {
        break;
    }
}

if ($failedBVN) {
    $jsonData = json_decode($failedBVN['data'], true);
    echo json_encode(['status' => false, 'message' => $jsonData['msg'] ?? $jsonData['message']]);
    exit;
}

// Step 3: Fetch BVN from Mono API
$apiUrl = 'https://api.withmono.com/v2/lookup/bvn';
$apiKey = 'live_sk_t434z01lpijmabq27au5';

$data = ['bvn' => $bvn];
$headers = [
    'accept: application/json',
    'content-type: application/json',
    'mono-sec-key: ' . $apiKey
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

$jsonResponse = json_decode($response, true);

if ($jsonResponse && $jsonResponse['status'] === 'successful') {
    $verificationCode = rand(1000, 9999);
    $phoneNumber = $jsonResponse['data']['phone'] ?? $jsonResponse['data']['phone_number'] ?? $jsonResponse['data']['phoneNo'] ?? null;

    insertBVNRecord($conn, 'dumps_bvn', $agentId, 'mono', $bvn, $response, 'good', $phoneNumber);

    if (updateAgentAccount($conn, $verificationCode, '', $nin, $response, $agentId) && sendVerificationSMS($phoneNumber, $verificationCode)) {
        echo json_encode(['status' => true, 'message' => $phoneNumber, 'bvn' => $bvn]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to update agent account.']);
    }
} else {
    insertBVNRecord($conn, 'dumps_bvn_failed', $agentId, 'mono', $bvn, $response);
    echo json_encode(['status' => false, 'message' => 'BVN verification failed.']);
}

function send_message($phone, $type = 1, $message, $sender) {
    // Configuration
    $key = "TXTNG-4Q4W0GR6TDAEXWBYQ2O2OJNEEW0ZNFOHN7QJDXN25SKQQ6QKANZ";
    $route = "2";
    $url = $type === 1 
        ? "https://api.textng.xyz/pushsms/" 
        : "https://api.textng.xyz/otp-sms/";
    
    // Parameters
    $params = [
        "key" => $key,
        "phone" => $phone,
        "message" => $message,
        "route" => $route,
        "sender" => $sender,
        "siscb" => $type === 1 ? 1 : 0,
    ];
    
    // Send HTTP POST request
    $response = httpPost($url, $params);
    
    // Extract Reference Number
    if (preg_match("/Reference:(.*?)\s\|\|/", $response, $matches)) {
        return trim($matches[1]); // Return the extracted reference number
    }
    
    // Return false if reference number is not found
    return false;
}


$conn->close();

?>
