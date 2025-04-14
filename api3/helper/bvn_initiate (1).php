<?php 
session_start();

include './config/dbcon.php';
include './utilities/utilities.php';

//
$agentId = $_SESSION['agent_id'];

$response = false;  // Initialize the response as false
function isValidBVN($bvn) {
    // Remove any non-numeric characters from the BVN
    $bvn = preg_replace('/[^0-9]/', '', $bvn);
    if (strlen($bvn) !== 11) {
        return false;
    }
    return true;
}


if (isValidBVN($bvn)){
    //Check our Bvn DB First.
    $sql = "SELECT `user_id`, `source`, `bvn`, `data` FROM dumps_bvn WHERE bvn = '$bvn' LIMIT 1";
    //echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Output data of each row
        $row = $result->fetch_assoc();
        $user_id = $row["user_id"];
        $bvn = $row["bvn"];
        $json_data = $row["data"];
        $source = $row['source'];
    
        // Decode JSON data
        $jsonData = json_decode($json_data,true);
        
        include 'bvn_refix.php';
        
        // Generate a 4-digit code
        $verificationCode = rand(1000, 9999);
        $bvn = "";
        // Update BVN and NIN in the agent_accounts table
        $stmt = $conn->prepare("UPDATE agent_accounts SET otp = ?, bvn = ?, nin = ?, extra = ? WHERE id = ?");
        
        $stmt->bind_param("ssssi", $verificationCode, $bvn, $nin, $json_data, $agentId);
        
        if ($stmt->execute()) {
            // Successfully updated the OTP in the database, now send an SMS
            if (send_message($phone_number, 2, "Your enetworksPay bvn authentication code is: $verificationCode. Do not share this with anyone.", "ENETWORKS")) {
                echo json_encode(array('status' => true, 'message' => $phone_number,'bvn'=>$bvn_oold));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => $decoded_data));
        }

    } 
    else {
        // Check our BVN DB first from 1app
        $result_1app = $conn->query("SELECT `data` FROM dumps_bvn_failed WHERE bvn = '$bvn' AND source = '1app' LIMIT 1");
        if ($result_1app->num_rows > 0) {
            // Output data of each row
            $row = $result_1app->fetch_assoc();
            $json_data = $row["data"];
            // Decode JSON data
            $json1appData = json_decode($json_data, true);
        } 
        
        // Check our BVN DB first from mono
        $sql_mono = "SELECT `data` FROM dumps_bvn_failed WHERE bvn = '$bvn' AND source = 'mono' LIMIT 1";
        $result_mono = $conn->query($sql_mono);
        if ($result_mono->num_rows > 0) {
            // Output data of each row
            $row = $result_mono->fetch_assoc();
            $json_data = $row["data"];
            $jsonData = json_decode($json_data, true);
        } 
        
        if ($json1appData['status'] == false && $json1appData['msg'] == "Oops! Unable to verify BVN. Kindly enter a valid BVN and try again") {
            echo json_encode(array('status' => false, 'message' => $json1appData['msg']));
        } else if ($jsonData['status'] == "failed" && $jsonData['message'] == "Invalid bvn supplied, please check the bvn and try again.") {
            echo json_encode(array('status' => false, 'message' => $jsonData['message']));
        }
        else{
            // Try Checking Mono
            $apiUrl = 'https://api.withmono.com/v2/lookup/bvn';
            $apiKey = 'live_sk_t434z01lpijmabq27au5';
            
            $data = [
                'bvn' => $bvn
            ];
            
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
            
            $resp = curl_exec($ch);
            
            if (curl_errno($ch)) {
                echo json_encode(array('status'=> true, 'message'=> curl_error($ch)));
            } 
            else {
                // Handle the response as needed
                $jsonData = json_decode($resp,true);
                
                //Make sure json valid
                if ($jsonData === null && json_last_error() !== JSON_ERROR_NONE) {
                        
                    // Remove 500 characters from the front
                    $modifiedJsonString = substr($row["data"],0, -1300);
                            
                    // Concatenate with the closing string
                    $modifiedJsonString .= '","watchListed":null}}';
                            
                    // Attempt to reparse the modified JSON
                    $modifiedJsonData = json_decode($modifiedJsonString,true);
                            
                    // Check if re-parsing was successful
                    if ($modifiedJsonData !== null || json_last_error() === JSON_ERROR_NONE) {
                                
                        // JSON parsing was successful
                        $response = $modifiedJsonData;
                        $status = 'false';
                    
                    }
                } 
                else{
                    $status = 'good';
                    $response = json_decode($resp,true);
                }
                
                if ($response['status'] == "successful"){
                    
                    $decoded_data = $response;
                 
                    if (isset($decoded_data['data']['phone'])) {
                        $phone_number = $decoded_data['data']['phone'];
                    } elseif (isset($decoded_data['data']['phone_number'])) {
                        $phone_number = $decoded_data['data']['phone_number'];
                    } elseif (isset($decoded_data['data']['phoneNo'])) {
                        $phone_number = $decoded_data['data']['phoneNo'];
                    }
                    
                    mysqli_query($conn,"INSERT INTO `dumps_bvn` (`user_id`, `source`, `bvn`, `data`,`status`, `phone_number`) VALUES ('$agentId','mono','$bvn','$resp','$status','$phone_number')");
                    
                    // Generate a 4-digit code
                    $verificationCode = rand(1000,9999);
                    
                    $bvn = "";
                    // Update BVN and NIN in the agent_accounts table
                    $stmt = $conn->prepare("UPDATE agent_accounts SET otp = ?, bvn = ?, nin = ?, extra = ? WHERE id = ?");
                    $stmt->bind_param("ssssi", $verificationCode, $bvn, $nin, $resp, $agentId);
                    if ($stmt->execute()) {
                        // Successfully updated the OTP in the database, now send an SMS
                        if(send_message($phone_number,2, "Your enetworksPay bvn authentication code is: $verificationCode. Do not share this with anyone.","ENETWORKS")){
                            echo json_encode(array('status'=> true, 'message'=> $phone_number.'|','bvn'=>$bvn_oold));
                        }
                    } else {
                        echo json_encode(array('status'=> false, 'message'=> "Oops! Unable to verify BVN. Kindly enter a valid BVN and try and again.(109)"));
                    }
                    curl_close($ch);
                }else{
                    mysqli_query($conn,"INSERT INTO `dumps_bvn_failed` ( `user_id`, `source`, `bvn`, `data`) VALUES ('$agentId','mono','$bvn','$resp')");
                    
                    $public_key = "1applive_pb_14f1ba3704b6acea63fe0a3e5a1e67e1";
                    $activepaystackapi= "1applive_sk_5d23b733b51eaffd106f18a15e69b1b4";
                    $authlink="";
                    $valid=false;
                
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.oneappgo.com/v1/bvnkyc",
                    
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode(['bvnno' => $bvn,'verify_type'=> "premium"]),
                    CURLOPT_HTTPHEADER => [
                        "authorization: Bearer $activepaystackapi",
                        "content-type: application/json",
                        "cache-control: no-cache"
                    ],
                    ));
                
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        echo json_encode(array('status'=> false, 'message'=> "Oops! Unable to verify BVN. try and again.(New)"));
                        // //Use Marasoft As Callback
                        // $api_url = "https://api.marasoftpay.live/identity/verify-bvn";
            
                        // // Your enc_key and bvn values
                        // $enc_key = getAnyData($conn, 'system_settings','id',1,"enc_key");
                            
                        // // POST data
                        // $post_data = array(
                        //     'enc_key' => $enc_key,
                        //     'bvn' => $bvn,
                        // );
                            
                        // // Initialize cURL session
                        // $ch = curl_init();
                            
                        //     // Set cURL options
                        // curl_setopt($ch, CURLOPT_URL, $api_url);
                        // curl_setopt($ch, CURLOPT_POST, 1);
                        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
                        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            
                        //     // Execute cURL session and get the response
                        // $response = curl_exec($ch);
                            
                        //     // Check for cURL errors
                        // if (curl_errno($ch)) {
                        //     echo 'cURL Error: ' . curl_error($ch);
                        // }
                        // // Close cURL session
                        // curl_close($ch);
                        
                        // //Display the API response
                        // $res = json_decode($response);
                         
                        // mysqli_query($conn,"INSERT INTO `dumps_bvn`( `user_id`, `source`, `bvn`, `data`) VALUES ('$agentId','marasoftpay','$bvn','$response')");
                         
                        //  // Generate a 4-digit code
                        // $verificationCode = rand(1000, 9999);
                        // $bvn = "";
                        // // Update BVN and NIN in the agent_accounts table
                        // $stmt = $conn->prepare("UPDATE agent_accounts SET otp = ?, bvn = ?, nin = ?, extra = ? WHERE id = ?");
                        // $stmt->bind_param("ssssi", $verificationCode, $bvn, $nin, $response, $agentId);
                        // if ($stmt->execute()) {
                        //     // Successfully updated the OTP in the database, now send an SMS
                        //     if(send_message($res['data']['phoneNo'],2 ,"Your bvn verification code is $verificationCode","Enetworkspay")){
                        //         echo json_encode(array('status'=> true, 'message'=> $res['data']['phoneNo']));
                        //     }
                        // } 
                        // else {
                        //     echo json_encode(array('status'=> false, 'message'=> $conn->error));
                        // }
                        
                         
                    } else {
                        $jsonData = json_decode($response,true);
                
                        //Make sure json valid
                        if ($jsonData === null && json_last_error() !== JSON_ERROR_NONE) {
                                
                            // Remove 500 characters from the front
                            $modifiedJsonString = substr($row["data"],0, -1300);
                                    
                            // Concatenate with the closing string
                            $modifiedJsonString .= '","watchListed":null}}';
                                    
                            // Attempt to reparse the modified JSON
                            $modifiedJsonData = json_decode($modifiedJsonString,true);
                                    
                            // Check if re-parsing was successful
                            if ($modifiedJsonData !== null || json_last_error() === JSON_ERROR_NONE) {
                                        
                                // JSON parsing was successful
                                $res = $modifiedJsonData;
                                $status = 'false';
                            
                            }
                        } 
                        else{
                            $status = 'good';
                            $res = json_decode($response,true);
                        }
                        
                        if ($res['status'] == true){
                            
                            if (isset($res['data']['phone'])) {
                                $phone_number = $res['data']['phone'];
                            }elseif (isset($res['data']['phone_number'])) {
                                $phone_number = $res['data']['phone_number'];
                            }elseif (isset($res['data']['phoneNo'])) {
                                $phone_number = $res['data']['phoneNo'];
                            }
                            
                            mysqli_query($conn,"INSERT INTO `dumps_bvn`( `user_id`, `source`, `bvn`, `data`,`status`, `phone_number`) VALUES ('$agentId','1app','$bvn','$response','$status','$phone_number')");
                    
                            // Generate a 4-digit code
                            $verificationCode = rand(1000, 9999);
                            $bvn = "";
                            // Update BVN and NIN in the agent_accounts table
                            $stmt = $conn->prepare("UPDATE agent_accounts SET otp = ?, bvn = ?, nin = ?, extra = ? WHERE id = ?");
                            $stmt->bind_param("ssssi", $verificationCode, $bvn, $nin, $response, $agentId);
                            if ($stmt->execute()) {
                                // Successfully updated the OTP in the database, now send an SMS
                                if(send_message($phone_number,2 ,"Your enetworksPay bvn authentication code is: $verificationCode. Do not share this with anyone.","ENETWORKS")){
                                    echo json_encode(array('status'=> true, 'message'=> $phone_number.'||','bvn'=>$bvn_oold));;
                                }
                            } else {
                                echo json_encode(array('status'=> false, 'message'=> "Oops! Unable to verify BVN. Kindly enter a valid BVN and try and again.(New)"));
                            }
                        }
                        else {
                            mysqli_query($conn,"INSERT INTO `dumps_bvn_failed` ( `user_id`, `source`, `bvn`, `data`) VALUES ('$agentId','1app','$bvn','$response')");
                            echo json_encode(array('status'=> false, 'message'=> "Invalid bvn supplied, please check the bvn and try again."));
                        }
                        
                  }
                }
            }
        }
        
    }
    // Close connection
    $conn->close();
    
}
else{
    echo json_encode(array('status'=> false, 'message'=> "Invalid BVN. Please enter a valid 11-digit BVN."));
}


?>
