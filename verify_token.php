<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "MY_SUPER_SECRET_KEY";

// Get headers
$headers = getallheaders();

if (!isset($headers['Authorization'])) {
    die("Access Denied - No Token");
}

$token = str_replace("Bearer ", "", $headers['Authorization']);

try {
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    return $decoded;

} catch (Exception $e) {
    die("Invalid or Expired Token");
}