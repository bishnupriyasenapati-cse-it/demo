<?php
// Include the database connection file
include 'db.php';

// Set the response content type to JSON
header('Content-Type: application/json');

// Check if the required POST parameter 'plan_id' is set
if(isset($_POST['plan_id'])){

    // Retrieve POST parameters
    $id = $_POST['plan_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    try {
        // Prepare an SQL statement to update the membership plan
        $stmt = $pdo->prepare("UPDATE membership_plans 
                               SET name=?, price=?, description=? 
                               WHERE id=?");
        
        // Execute the statement with the provided values
        $stmt->execute([$name, $price, $description, $id]);

        // Return a success response as JSON
        echo json_encode(['status'=>'success']);
    } catch (PDOException $e) {
        // Return an error response if the query fails
        echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
    }

} else {
    // Return an error response if 'plan_id' is missing
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
}
?>