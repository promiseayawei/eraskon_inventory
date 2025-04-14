<?php
include_once('jwtFunction.php');

// Function to get Authorization header
function getAuthorizationHeader()
{
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) { // For servers that use 'HTTP_AUTHORIZATION'
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('getallheaders')) {
        $allHeaders = getallheaders();
        if (isset($allHeaders['Authorization'])) {
            $headers = trim($allHeaders['Authorization']);
        } else if(isset($allHeaders['Authorize'])) {
            $headers = trim($allHeaders['Authorize']);
        }
    }
    return $headers;
}

// Function to get the Bearer token
function getBearerToken()
{
    $headers = getAuthorizationHeader();
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

// Validate the token
$token = getBearerToken();
if (empty($token) || !verifyJWT($token)) {
    $data = [
        'status' => 401,
        'message' => 'Unauthorized Access',
    ];
    header("HTTP/1.0 401 Unauthorized Access");
    die(json_encode($data));
}
