<?php
include 'db.php';

header('Content-Type: application/json');

if (!isset($_GET['member_id'])) {
    echo json_encode(['error' => 'Member ID required']);
    exit;
}

$member_id = intval($_GET['member_id']);

try {

    // ✅ CASE-INSENSITIVE MATCH (FIXED)
    $stmt = $pdo->prepare("
        SELECT m.name, mp.price, m.membership
        FROM members m
        LEFT JOIN membership_plans mp 
        ON LOWER(TRIM(m.membership)) = LOWER(TRIM(mp.name))
        WHERE m.id = ?
    ");

    $stmt->execute([$member_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode(['error' => 'Member not found']);
        exit;
    }

    // ✅ If no match, show exact issue
    if ($data['price'] === null) {
        echo json_encode([
            'name' => $data['name'],
            'price' => 0,
            'error' => 'Plan mismatch: ' . $data['membership']
        ]);
        exit;
    }

    echo json_encode([
        'name' => $data['name'],
        'price' => (float)$data['price']
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error']);
}
