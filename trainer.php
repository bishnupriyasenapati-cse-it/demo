<?php 
// Include the header file (navigation, meta, etc.)
include 'header.php'; 

// Start the session
session_start();

// Check if admin is logged in; if not, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<style>
/* Trainer card styles */
.trainer-card {
    border-radius: 15px;
    overflow: hidden;
    transition: 0.3s;
}

.trainer-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.trainer-img {
    height: 220px;
    object-fit: cover;
}

.badge-role {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #000;
    color: #fff;
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 12px;
}

.rating {
    color: gold;
}

.section-title {
    font-weight: 600;
}
</style>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-lg-2">
            <?php include 'sidebar.php'; // Include the admin sidebar ?>
        </div>

        <!-- Main Content -->
        <div class="col-lg-10">

            <!-- Dashboard title -->
            <h2 class="mb-4">🏋️ Trainers Dashboard</h2>

            <div class="row g-4">

                <!-- Trainer 1 Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card trainer-card shadow position-relative">

                        <!-- Trainer role badge -->
                        <span class="badge-role">Fitness</span>

                        <!-- Trainer image -->
                        <img src="images/fitness trainer.webp" class="card-img-top trainer-img">

                        <div class="card-body text-center">
                            <h5>Rahul Sharma</h5>
                            <p class="text-muted">Weight Trainer</p>

                            <!-- Star rating -->
                            <div class="rating mb-2">⭐⭐⭐⭐⭐</div>

                            <!-- Profile modal trigger -->
                            <button class="btn btn-outline-primary btn-sm w-100"
                                data-bs-toggle="modal" data-bs-target="#trainer1">
                                View Profile
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Trainer 2 Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card trainer-card shadow position-relative">

                        <span class="badge-role bg-success">Yoga</span>
                        <img src="images/yoga trainer.jpg" class="card-img-top trainer-img">

                        <div class="card-body text-center">
                            <h5>Sangeeta K</h5>
                            <p class="text-muted">Yoga Trainer</p>

                            <div class="rating mb-2">⭐⭐⭐⭐☆</div>

                            <button class="btn btn-outline-success btn-sm w-100"
                                data-bs-toggle="modal" data-bs-target="#trainer2">
                                View Profile
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Trainer 1 Modal -->
<div class="modal fade" id="trainer1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Rahul Sharma</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="images/fitness trainer.webp" class="rounded-circle mb-3" width="120">

                <!-- Trainer details -->
                <p><strong>Email:</strong> rahul@email.com</p>
                <p><strong>Phone:</strong> 9876543210</p>
                <p><strong>Specialization:</strong> Weight Training</p>
                <p><strong>Certificate:</strong> ACE Certified</p>
            </div>

        </div>
    </div>
</div>

<!-- Trainer 2 Modal -->
<div class="modal fade" id="trainer2">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Sangeeta K</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="images/yoga trainer.jpg" class="rounded-circle mb-3" width="120">

                <!-- Trainer details -->
                <p><strong>Email:</strong> sangeeta@email.com</p>
                <p><strong>Phone:</strong> 9876545678</p>
                <p><strong>Specialization:</strong> Yoga</p>
                <p><strong>Certificate:</strong> ACE Certified</p>
            </div>

        </div>
    </div>
</div>

<?php 
// Include the footer section
include 'footer.php'; 
?>