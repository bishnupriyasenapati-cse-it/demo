<?php
require 'db.php';
header('Content-Type: application/json');

// 🔒 Allow only POST JSON
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request method"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['transaction_id'], $data['status'])) {
    echo json_encode(["error" => "Invalid payload"]);
    exit;
}

$stmt = $pdo->prepare("
    UPDATE payments 
    SET status = ? 
    WHERE transaction_id = ?
");

$stmt->execute([$data['status'], $data['transaction_id']]);

echo json_encode(["status" => "success"]);
