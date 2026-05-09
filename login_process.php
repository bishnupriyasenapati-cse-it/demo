<?php
session_start();
header('Content-Type: application/json');

require 'db.php';

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Check empty fields
if ($username === '' || $password === '') {
    echo json_encode([
        "status" => "error",
        "message" => "Missing username or password"
    ]);
    exit;
}

// Get user from DB
$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If user not found
if (!$user) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid login"
    ]);
    exit;
}

// PASSWORD CHECK (SECURE)
if (password_verify($password, $user['password'])) {

    // Set session
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin'] = $user['username'];
    $_SESSION['logged_in'] = true;

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Invalid login"
    ]);
}
?>