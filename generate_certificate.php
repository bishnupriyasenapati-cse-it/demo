<?php 
// Include header layout (HTML head, navbar, etc.)
include 'header.php'; 

// Start session to access admin login data
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // If not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}
?>

<div class="d-flex">

    <!-- Include sidebar navigation -->
    <?php include 'sidebar.php'; ?>

    <!-- MAIN CONTENT AREA -->
    <div class="container-fluid p-4" style="min-height:100vh;">

        <!-- Page title -->
        <h3 class="mb-4">Generate Certificate</h3>

        <!-- Card container for form -->
        <div class="card shadow p-4">

            <!-- Form to send data to certificate.php using GET method -->
            <!-- target="_blank" opens the certificate in a new tab -->
            <form method="GET" action="certificate.php" target="_blank">

                <!-- Member Name Input -->
                <div class="mb-3">
                    <label class="form-label">Member Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <!-- Certificate Type Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Certificate Type</label>
                    <select name="type" class="form-select">
                        <option value="member">Member</option>
                        <option value="trainer">Trainer</option>
                    </select>
                </div>

                <!-- Program Name Input -->
                <div class="mb-3">
                    <label class="form-label">Program</label>
                    <input type="text" name="program" class="form-control">
                </div>

                <!-- Trainer Name Input -->
                <div class="mb-3">
                    <label class="form-label">Trainer Name</label>
                    <input type="text" name="trainer" class="form-control">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <!-- Bootstrap icon for visual enhancement -->
                    <i class="bi bi-award me-2"></i> Generate Certificate
                </button>

            </form>

        </div>

    </div>

</div>

<?php 
// Include footer layout (scripts, closing tags)
include 'footer.php'; 
?>