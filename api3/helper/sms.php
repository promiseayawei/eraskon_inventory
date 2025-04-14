<?php
require_once('vendor/autoload.php');

// function send_message($phone, $message, $sender)
// {
//     $client = new \GuzzleHttp\Client();
//     $apiUrl = 'https://api.smslive247.com/api/v4/sms';
//     $apiKey = 'MA-8f272439-33c8-4a28-9fae-2316d9bd03be';

//     try {
//         $response = $client->request('POST', $apiUrl, [
//             'json' => [
//                 'senderID' => $sender,
//                 'messageText' => $message,
//                 'deliveryTime' => date('c'),
//                 'mobileNumber' => $phone,
//             ],
//             'headers' => [
//                 'Authorization' => $apiKey,
//                 'Accept' => 'application/json',
//                 'Content-Type' => 'application/json',
//             ],
//         ]);

//         $body = json_decode($response->getBody(), true);
        
//         if (isset($body['status']) && strtolower($body['status']) === 'success') {
//             return true;
//         }

//         error_log("SMS API Error: " . json_encode($body));
//         return false;
//     } catch (\GuzzleHttp\Exception\RequestException $e) {
//         error_log("SMS API Request Error: " . $e->getMessage());
//         return false;
//     }
// }

function send_message($phone,$type=1,$message,$sender){
    // Your variables
    $key="TXTNG-4Q4W0GR6TDAEXWBYQ2O2OJNEEW0ZNFOHN7QJDXN25SKQQ6QKANZ";
    $route="2";
    if ($type == 1){
        $response = httpPost("https://api.textng.xyz/pushsms/",array("key"=>"$key","phone"=>"$phone","message"=>"$message","route"=>"$route","sender"=>"$sender","siscb" => 1));
    }
    else if($type == 2){
        $response = httpPost("https://api.textng.xyz/otp-sms/",array("key"=>"$key","sender"=>"$sender","phone"=>"$phone","message"=>"$message","route"=>"$route","siscb" => 0));
    }
    
    //Getting the Reference Number 
    // extract text in front of "Reference:"
    $reference_text = "";
    if (preg_match("/Reference:(.?)\s\|\|/", $response, $matches)) {
        $reference_text = trim($matches[1]);
    }
    return true;
}