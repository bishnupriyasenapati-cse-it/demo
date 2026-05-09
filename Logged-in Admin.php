<?php
// Include database connection
require 'db.php';

// Get the logged-in admin's name from the session
$adminName = $_SESSION['admin'];

// Prepare and execute SQL statement to fetch admin details
$stmt = $pdo->prepare("SELECT * FROM admins WHERE name = ?");
$stmt->execute([$adminName]);

// Fetch the admin record as an associative array
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
?>