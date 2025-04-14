/project
  ├── /config
  │     └── dbcon.php
  ├── /users
  │     ├── signup.php
  │     ├── read.php
  │     ├── login.php
  │     ├── forget-password.php
  │     ├── function.php
  ├── /vendor
  ├── .env
  ├── composer.json
  ├── README.md


<!-- 
----- dbcon.php
<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "phptutorial";

$conn = mysqli_connect($host, $username, $password, $dbname);
if(!$conn){
    die("connection Failed: " . mysqli_connect_error());
}
?>

------ function.php
<?php
require '../dbcon.php';

function error422($message){
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
}

function storeCustomer($customerInput){
    global $conn;
    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if(empty(trim($name))){
         return error422('Enter your name');
          
    }elseif(empty(trim($email))){
        return error422('Enter your email');
    }elseif(empty(trim($phone))){
        return error422('Enter your phone');
    }

    else 
    {
        $query = "INSERT INTO customers (name, email,phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' => 'ICustomer Created Successfully',
            ];
            header("HTTP/1.0 201 created");
            return json_encode($data);

        }else{
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);

        }
    }
}

function getCustomer($customerParams){
    global $conn;

    if ($customerParams['id'] == null){
        return error422('Enter your customer id');
    }
    
}


function getCustomerList(){
    global $conn;

    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run, 2);

            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched Successfully',
                'data' => $res,
            ];
            header("HTTP/1.0  200 Customer List Fetched Successfully");
            return json_encode($data);
        } else{
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',
            ];
            header("HTTP/1.0 400 No Customer Found");
            return json_encode($data);
        }

    }
    else
    {
       $data = [
           'status' => 500,
           'message' => 'Internal Server Error',
       ];
       header("HTTP/1.0 500 Internal Server Error");
       return json_encode($data);
   }
    
}

?>


----create.php
<?php

error_reporting(0 );
 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: POST');
 header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, x-Request-with');

 include('function.php');
 $requestMethod = $_SERVER["REQUEST_METHOD"];
 
 if($requestMethod == "POST"){
    $inputData = json_decode(file_get_contents("php://input"), true);
     if(empty($inputData)){

        $storeCustomer = storeCustomer($_POST);
     }else{

        $storeCustomer = storeCustomer($_POST);
     }
        echo $storeCustomer;

 }else{
    $data = [
        'status' => 405,
        'message' => $requestMethod. 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
 }
?>

---- read.php
<?php
 header('Access-Control-Allow-Origin:*');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Method: GET');
 header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, x-Request-with');
include('function.php');


 $requestMethod = $_SERVER["REQUEST_METHOD"];
 
 if($requestMethod == "GET"){

    if(isset($_GET['id'])){
        $customer = getCustomer($_GET);
    }

    $customerList = getCustomerList();
    echo $customerList;
 }
 else
 {
    $data = [
        'status' => 405,
        'message' => $requestMethod. 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}


?> -->