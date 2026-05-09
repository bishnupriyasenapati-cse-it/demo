<?php

// Include the database connection file
include 'db.php';
header('Content-Type: application/json');

if($stmt->execute([$id])){
    echo json_encode([
        "status" => "success"
    ]);
} else {
    echo json_encode([
        "status" => "error"
    ]);
}
?>