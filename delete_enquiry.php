<?php
// Include database connection file
require 'db.php';

// Check if 'id' is sent via POST request
if(isset($_POST['id'])) {

    // Convert id to integer for security (prevents SQL injection)
    $id = intval($_POST['id']);

    try {

        // Prepare SQL statement to delete record with given id
        $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = ?");

        // Execute the query with the id parameter
        $stmt->execute([$id]);

        // If deletion is successful, return success message
        echo "success";

    } catch(PDOException $e) {

        // If any error occurs, return error message
        echo "error";
    }

} else {

    // If 'id' is not provided in POST request
    echo "invalid";
}
?>