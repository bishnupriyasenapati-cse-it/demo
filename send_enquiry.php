<?php
// Include database connection
include 'db.php';

// Check if the form was submitted via POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Get form data from POST request
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    // Prepare SQL statement to insert enquiry into database
    $stmt = $pdo->prepare("INSERT INTO enquiries (name,email,phone,message) VALUES (?,?,?,?)");

    // Execute the statement and check if insertion was successful
    if($stmt->execute([$name,$email,$phone,$message])){

        // Success: Show alert and redirect to home page
        echo "<script>
        alert('Enquiry Sent Successfully');
        window.location='home.php';
        </script>";

    }else{

        // Failure: Show error alert and redirect to home page
        echo "<script>
        alert('Something went wrong');
        window.location='home.php';
        </script>";

    }

}
?>
<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO enquiries (name,phone,email,message) VALUES (?,?,?,?)");

    if ($stmt->execute([$name, $phone, $email, $message])) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>