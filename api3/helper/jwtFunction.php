<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generateJWT($payload)
{
    $key = $_ENV['JWT_SECRET'];
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600; // 1 hour validity

    $token = JWT::encode(
        array_merge($payload, [
            "iat" => $issuedAt,
            "exp" => $expirationTime
        ]),
        $key,
        'HS256'
    );

    return $token;
}

function verifyJWT($token)
{
    try {
        $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
        return (array)$decoded;
    } catch (Exception $e) {
        return null;
    }
}
