<?php
require 'db.php';
header('Content-Type: application/json');

$response = [
    "status" => "error",
    "data" => [],
    "message" => ""
];

try {

    $stmt = $pdo->query("
        SELECT 
            p.id,
            p.member_id,
            IFNULL(m.name, 'Unknown') AS name,
            p.amount,
            p.payment_method,
            p.status,
            p.transaction_id,
            p.created_at
        FROM payments p
        LEFT JOIN members m ON p.member_id = m.id
        ORDER BY p.id DESC
    ");

    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$payments) {
        $response['status'] = "success";
        $response['message'] = "No records found";
        echo json_encode($response);
        exit;
    }

    // ✅ Sanitize output
    foreach ($payments as &$row) {
        $row['name'] = htmlspecialchars($row['name']);
        $row['payment_method'] = htmlspecialchars($row['payment_method']);
        $row['status'] = htmlspecialchars($row['status']);
    }

    $response['status'] = "success";
    $response['data'] = $payments;

    echo json_encode($response);

} catch (PDOException $e) {
    $response['message'] = "Database error";
    echo json_encode($response);
}
