<?php
// Include database connection
include 'db.php';

// Get the notification settings from the form submission
// If a checkbox is checked, its value will be 1, otherwise 0
$email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
$class_reminders = isset($_POST['class_reminders']) ? 1 : 0;
$payment_alerts = isset($_POST['payment_alerts']) ? 1 : 0;

// Prepare the SQL statement to update the settings in the database
$stmt = $pdo->prepare("UPDATE settings SET email_notifications=?, class_reminders=?, payment_alerts=? WHERE id=1");

// Execute the statement with the values from the form
if($stmt->execute([$email_notifications, $class_reminders, $payment_alerts])){
    // Success message
    echo "Notification settings updated successfully!";
} else {
    // Failure message
    echo "Failed to update notifications.";
}
?>