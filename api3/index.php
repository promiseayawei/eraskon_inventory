<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

// handle the env from here
$dotenv = Dotenv::createImmutable(__DIR__. '/');
$dotenv->load();

// handle major imports here for easier management
require_once 'helper/phpMailer.php';
require_once 'helper/jwtFunction.php';
require_once 'config/dbcon.php';


$public_routes = ['users/login', 'users/signUp', 'users/forgetPassword', 'users/resetPassword','admin/createProjectDirector','records/createRecord', 'records/create/refCreateRecord', 'helper/bvn', 'helper/bvn_verify', 'users/refUser'];

//arrange the path
if (empty($_REQUEST['path'])) {
    die(json_encode(array("code" => 403, "message" => "Request not understood.")));
}

$path = $_REQUEST['path'];
//remove trailing / from the path
$path = str_split($path);
if ($path[count($path) - 1] == '/') array_pop($path);
$path = implode("", $path);
//print_r($path);
//prepare for error 
$api_response = array(
    'code' => 403,
    'message' => "Access denied"
);

//check if route is an actual route
if (is_file($path . '.php')) {

    // authenticate only paths not in $public_routes
    if(!in_array($path, $public_routes)) {
        include_once 'helper/authenticatedSection.php';
    }

    // the actual route loading
    die(include $path . '.php');

} else {
    $api_response['error'] = 'Route does not exist';
}
die(json_encode($api_response));
