<?php
// Include database connection
require 'db.php';

// Get the enquiry ID and new status from POST request
$id = $_POST['id'];
$status = $_POST['status'];

// Prepare SQL statement to update the status of a specific enquiry
$stmt = $pdo->prepare("UPDATE enquiries SET status=? WHERE id=?");

// Execute the prepared statement with the new status and the enquiry ID
$stmt->execute([$status, $id]); // Updates the status in the database