<?php
// Include database connection
include 'db.php';

// Check if all required POST parameters are set
if(isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])){
    $current = $_POST['current_password'];   // User's current password input
    $new = $_POST['new_password'];           // User's new password input
    $confirm = $_POST['confirm_password'];   // User's confirmation of new password

    // Fetch current password from the database for admin with id=1
    $stmt = $pdo->prepare("SELECT password FROM admins WHERE id=1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Uncomment this block if you want to verify the current password
    /*
    if(!$row || !password_verify($current, $row['password'])){
        echo "Current password is incorrect.";
        exit;
    }
    */

    // Check if new password and confirmation match
    if($new !== $confirm){
        echo "New passwords do not match.";
        exit;
    }

    // Hash the new password securely
    $new_hashed = password_hash($new, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $pdo->prepare("UPDATE admins SET password=? WHERE id=1");
    if($stmt->execute([$new_hashed])){
        echo "Security settings updated successfully!";
    } else {
        echo "Failed to update security settings.";
    }

} else {
    // If required POST fields are missing
    echo "Invalid request.";
}
?>