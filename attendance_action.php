<?php
// Include database connection file
include 'db.php';

// Get data sent via POST request
$member_id = $_POST['member_id'];
$action = $_POST['action'];

// ===================== CHECK-IN LOGIC =====================
if ($action == 'checkin') {

    // Check if the member has already checked in today
    $check = $pdo->prepare("
        SELECT id FROM attendance 
        WHERE member_id = ? 
        AND DATE(checkin_time) = CURDATE()
    ");
    $check->execute([$member_id]);

    // If a record exists, prevent duplicate check-in
    if ($check->rowCount() > 0) {
        echo "Already checked in!";
        exit; // Stop further execution
    }

    // Insert new check-in record with current timestamp
    $stmt = $pdo->prepare("
        INSERT INTO attendance (member_id, checkin_time)
        VALUES (?, NOW())
    ");

    // Execute query and return result
    if ($stmt->execute([$member_id])) {
        echo "Checked in!";
    } else {
        echo "Error!";
    }
}

// ===================== CHECK-OUT LOGIC =====================
if ($action == 'checkout') {

    // Update the checkout time only if:
    // - Member checked in today
    // - Checkout has not already been done (checkout_time IS NULL)
    $stmt = $pdo->prepare("
        UPDATE attendance 
        SET checkout_time = NOW()
        WHERE member_id = ?
        AND DATE(checkin_time) = CURDATE()
        AND checkout_time IS NULL
    ");

    $stmt->execute([$member_id]);

    // Check if any row was updated
    if ($stmt->rowCount() > 0) {
        echo "Checked out!";
    } else {
        // Either already checked out OR no check-in found today
        echo "Already checked out!";
    }
}
?>