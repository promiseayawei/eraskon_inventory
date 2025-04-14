<?php
function checkBvnDetails($bvn, $publicKey, $secretKey)
{
    function isValidBVN($bvn) {
        // Remove any non-numeric characters from the BVN
        $bvn = preg_replace('/[^0-9]/', '', $bvn);
        if (strlen($bvn) !== 11) {
            return false;
        }
        return true;
    }

    $url = "https://api.withmono.com/v2/lookup/bvn";

    $payload = [
        'bvn' => $bvn
    ];

    $headers = [
        "accept: application/json",
        "content-type: application/json",
        "mono-sec-key: $secretKey"
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => $headers,
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return json_encode([
            'success' => false,
            'message' => "cURL Error: $error"
        ]);
    }

    $responseData = json_decode($response, true);
    if (isset($responseData['data']['phone'])) {
        $phone_number = $responseData['data']['phone'];
    } elseif (isset($responseData['data']['phone_number'])) {
        $phone_number = $responseData['data']['phone_number'];
    } elseif (isset($responseData['data']['phoneNo'])) {
        $phone_number = $responseData['data']['phoneNo'];
    }

    if ($responseData && $responseData['status'] === 'successful') {
        $verificationCode = rand(1000, 9999);
        $message = "Your verification code is: $verificationCode";
        $sender = "BVNVerify";
        send_message($phone_number, 1, $message, $sender);

        return json_encode([
            'success' => true,
            'data' => [                    
                'first_name' => $responseData['data']['first_name'],
                'last_name' => $responseData['data']['last_name'],
                'dob' => $responseData['data']['dob'],
                'phone' => $phone_number,
            ],
            'message' => $responseData['msg'] ?? 'BVN details fetched successfully',
        ]);
    } else {
        return json_encode([
            'success' => false,
            'data' => $responseData,
            'message' => $responseData['msg'] ?? 'Unable to fetch BVN details',
        ]);
    }
}

function send_message($phone, $type = 1, $message, $sender)
{
    $key = "TXTNG-4Q4W0GR6TDAEXWBYQ2O2OJNEEW0ZNFOHN7QJDXN25SKQQ6QKANZ";
    $route = "2";

    if ($type == 1) {
        $response = httpPost("https://api.textng.xyz/pushsms/", [
            "key" => $key,
            "phone" => $phone,
            "message" => $message,
            "route" => $route,
            "sender" => $sender,
            "siscb" => 1
        ]);
    } elseif ($type == 2) {
        $response = httpPost("https://api.textng.xyz/otp-sms/", [
            "key" => $key,
            "sender" => $sender,
            "phone" => $phone,
            "message" => $message,
            "route" => $route,
            "siscb" => 0
        ]);
    }

    $reference_text = "";
    if (preg_match("/Reference:(.?)\s\|\|/", $response, $matches)) {
        $reference_text = trim($matches[1]);
    }
    return true;
}



function httpPost($url, $params)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/x-www-form-urlencoded",
        ],
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        return "Error: $error";
    }

    return $response;
    print_r($response);
}
?>
