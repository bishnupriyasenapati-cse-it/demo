<?php
// Include database connection
include 'db.php';

// Check if the required POST data is set
if(isset($_POST['gym_name'], $_POST['email'], $_POST['phone'])){
    
    // Retrieve data from POST request
    $gym_name = $_POST['gym_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepare SQL statement to update general settings
    $stmt = $pdo->prepare("UPDATE settings SET gym_name=?, email=?, phone=? WHERE id=1");

    // Execute the statement with user-provided values
    if($stmt->execute([$gym_name, $email, $phone])){
        // Success message
        echo "General settings updated successfully!";
    } else {
        // Failure message
        echo "Failed to update settings.";
    }

} else {
    // If required POST data is missing
    echo "Invalid request.";
}
?>