<?php
// api for signUp POST REQUEST
include_once('admin/adminFunction.php');
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "POST") {
   $userInput = json_decode(file_get_contents("php://input"), true);
   if (empty($userInput)) {
      $createMobilizer = createMobilizer($_POST);
   } else {
      $createMobilizer = createMobilizer($userInput);
   }
   echo $createMobilizer;
} else {
   $data = [
      'status' => 405,
      'message' => $requestMethod . 'Method Not Allowed',
   ];
   header("HTTP/1.0 405 Method Not Allowed");
   echo json_encode($data);
}
