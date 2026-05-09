<?php
// Include database connection file
include 'db.php';

// Prepare SQL query to fetch all trainers
$stmt = $pdo->prepare("SELECT * FROM trainers");

// Execute the query
$stmt->execute();

// Loop through each trainer record
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>

    <!-- Trainer Card Column -->
    <div class="col-md-3 mb-4">

        <!-- Card Container -->
        <div class="card shadow">

            <!-- Trainer Image -->
            <img src="images/<?php echo $row['photo']; ?>" 
                 class="card-img-top" height="200">

            <!-- Card Body -->
            <div class="card-body text-center">

                <!-- Trainer Name -->
                <h5 class="card-title">
                    <?php echo $row['name']; ?>
                </h5>

                <!-- Trainer Details -->
                <p class="card-text">
                    Specialization: <?php echo $row['specialization']; ?><br>
                    Experience: <?php echo $row['experience']; ?> years
                </p>

                <!-- Action Buttons -->
                <button class="btn btn-primary btn-sm">View</button>
                <button class="btn btn-warning btn-sm">Edit</button>

            </div>

        </div>

    </div>

<?php 
} // End of while loop
?>