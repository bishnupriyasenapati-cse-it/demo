<?php
// Include the database connection file
include 'db.php';

// Get the dark mode value from POST request; default to 0 if not set
$dark_mode = $_POST['dark_mode'] ?? 0;

// Prepare an SQL statement to update the dark_mode setting in the database
$stmt = $pdo->prepare("UPDATE settings SET dark_mode = ? WHERE id = 1");

// Execute the SQL statement with the provided dark_mode value
$stmt->execute([$dark_mode]);

// Return a success message
echo "success";
?>