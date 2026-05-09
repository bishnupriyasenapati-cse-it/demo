<?php
// Include the database connection file
require 'db.php';

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the ID and message from the POST request, or set as empty string if not provided
    $id = $_POST['id'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validate input data
    if (!$id || !$message) {
        echo "Missing data"; // Return error if required data is missing
        exit;
    }

    try {
        // Prepare the SQL statement to update the enquiry with a reply and change status to 'replied'
        $stmt = $pdo->prepare("UPDATE enquiries SET reply=?, status='replied' WHERE id=?");
        
        // Execute the statement with the provided message and ID
        $stmt->execute([$message, $id]);

        echo "success"; // Return success message

    } catch (Exception $e) {
        // Catch any errors and display the exception message
        echo $e->getMessage();
    }

} else {
    // If request method is not POST, return invalid request
    echo "Invalid request";
}
?>