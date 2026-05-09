<?php
// Include database connection file
include 'db.php';

// Set response type to JSON
header('Content-Type: application/json');

// Prepare SQL query to count total rows in 'enquiries' table
$stmt = $pdo->prepare("SELECT COUNT(*) FROM enquiries");

// Execute the query
$stmt->execute();

// Fetch the count result
$count = $stmt->fetchColumn();

// Return the result as JSON
echo json_encode([
    "count" => $count
]);