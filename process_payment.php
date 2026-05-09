<?php
require 'db.php';
header('Content-Type: application/json');

if (!isset($_POST['member_id'], $_POST['amount'], $_POST['method'])) {
    echo json_encode(["status"=>"error","message"=>"Missing fields"]);
    exit;
}

$member_id = intval($_POST['member_id']);
$amount = floatval($_POST['amount']);
$method = $_POST['method'];

if($amount <= 0){
    echo json_encode(["status"=>"error","message"=>"Invalid amount"]);
    exit;
}

try {
    $transaction_id = "TXN" . time() . rand(1000,9999);

    $stmt = $pdo->prepare("
        INSERT INTO payments 
        (member_id, amount, payment_method, status, transaction_id, created_at)
        VALUES (?, ?, ?, 'pending', ?, NOW())
    ");

    $stmt->execute([$member_id, $amount, $method, $transaction_id]);

    echo json_encode([
        "status" => "success",
        "transaction_id" => $transaction_id
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status"=>"error",
        "message"=>"DB Error"
    ]);
}
