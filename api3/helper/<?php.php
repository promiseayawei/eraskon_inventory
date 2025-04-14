<?php
session_start();
$mono_secret_key = 'live_sk_t434z01lpijmabq27au5'; // Replace with your actual Mono secret key

if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];

    echo "Session ID: " . $session_id . "\n";
    echo "Verification Methods:\n";

    if (isset($_GET['otp'])) {
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
        curl_close($ch);

        if ($response) {
            //retrieve user details by id
            $user_id = $_SESSION['user_id'];

            $query = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) if ($result) {
                if ($result->num_rows > 0) {
                    $res = $result->fetch_assoc();
                    $_SESSION['email'] = $res['email'];
                    $_SESSION['phone'] = $res['phone'];
                    $_SESSION['first_name'] = $res['first_name'];
                    $_SESSION['last_name'] = $res['last_name'];
                    $_SESSION['nin'] = $res['nin'];
                    $_SESSION['state'] = $res['state'];
                    $_SESSION['account_type'] = $res['account_type'];
                }
            }

            //bvn in update user details
            $bvn = $_SESSION['bvn'];
            $query = "UPDATE users SET bvn = '$bvn' and status = 'make payment' WHERE id = '$user_id'";

            if (mysqli_query($conn, $query)) {
                $data = [
                    'status' => 201,
                    'message' => 'BVN verified Successfully',

                ];

                header("HTTP/1.0 201 Created");
                return json_encode($data);
            } else {
                return json_encode(['status' => 500, 'message' => 'Error updating BVN']);
            }
            //send payload for account number

            $payload = [

                "id" => $_SESSION['user_id'],
                "email" => $_SESSION['email'],
                "phone" => $_SESSION['phone'],
                "first_name" => $_SESSION['first_name'],
                "last_name" => $_SESSION['last_name'],
                "bvn" => $_SESSION['bvn'],
                "nin" => $_SESSION['nin'],
                "state" => $_SESSION['state'],
                "account_type" => $_SESSION['account_type'],
                "status" => "make payment"


            ];

            echo "\nPayload data: " . $payload;
            //sendUserDataToExternalAPI($payload);
        }

        function sendUserDataToExternalAPI($payload)
        {
            $apiUrl = "localhost/kalpep-api-test/users/signUp"; // Replace with actual API URL

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer your_api_key_here' // If authentication is required
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200) {
                $responseData = json_decode($response, true);
                return $responseData['account_number'] ?? 'N/A';
            } else {
                return 'N/A'; // Return 'N/A' if the API request fails
            }
        }

        // echo "\nBVN Details Response: " . $response;
    } else {
        echo "\nNo OTP received.";
    }
}
