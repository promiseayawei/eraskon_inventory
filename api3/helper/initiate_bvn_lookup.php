<?php
session_start();

function initiate_bvn_lookup($userInput){

    global $conn;

    $bvnno = mysqli_real_escape_string($conn, $userInput['bvnno']);
    

    if (empty(trim($bvnno))) {
        return error422('Enter your email');
    }
    $mono_secret_key = 'live_sk_t434z01lpijmabq27au5'; // Replace with your actual Mono secret key
    $url = 'https://api.withmono.com/v2/lookup/bvn/initiate';
    
    $data = [
        'bvn' => $bvnno, // Replace with the actual BVN
        'scope' => 'identity' // or 'identity'
    ];
    
    $payload = json_encode($data);
    
    $headers = [
        'Content-Type: application/json',
        'mono-sec-key: ' . $mono_secret_key
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200) {
        $decoded_response = json_decode($response, true);
        
    
        if ($decoded_response && isset($decoded_response['data'])) {
            $session_id = $decoded_response['data']['session_id'];
            $bvn = $decoded_response['data']['bvn'];
            $methods = $decoded_response['data']['methods'];
        
            echo "Session ID: " . $session_id . "\n";
            echo "BVN: " . $bvn . "\n";
            echo "Verification Methods:\n";
            $_SESSION['bvn'] = $bvn;
        }
    
        
        $url = 'https://api.withmono.com/v2/lookup/bvn/verify';
        
        $data = [
            'method' => 'phone', // Choose from "phone", "phone_1", "alternate_phone", or "email"
            //'phone_number' => '08012345678' // Required if method is "alternate_phone"
        ];
        
        $payload = json_encode($data);
        
        $_SESSION['session_id'] = $session_id;
        
        $headers = [
            'Content-Type: application/json',
            'mono-sec-key: ' . $mono_secret_key,
            'x-session-id: '.  $session_id
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $_SESSION['bvn'] = $bvnno;
            echo "Response: " . $response;
        } else {
            echo "Error: " . $response;
        }
    } else {
        echo "Error: " . $response;
    }
    
}


?>
    




