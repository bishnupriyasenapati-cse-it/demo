<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gym", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    // ✅ Return JSON instead of plain text
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]);

    exit; // ❗ stop execution
}
?>