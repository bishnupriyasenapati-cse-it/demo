<?php 
// Include header file (common UI/header section)
include 'header.php'; 

// Start session to access session variables
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
    <div class="container-fluid p-4">

        <!-- Page title -->
        <h3 class="mb-4">Generate Joining Letter</h3>

        <!-- Card container for form -->
        <div class="card shadow p-4">

            <!-- Form to send data to joining_letter.php -->
            <!-- method=GET → data visible in URL -->
            <!-- target=_blank → opens result in new tab -->
            <form method="GET" action="joining_letter.php" target="_blank">

                <!-- Employee Name Input -->
                <div class="mb-3">
                    <label>Employee Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <!-- Employee Type Dropdown -->
                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="staff">Staff</option>
                        <option value="trainer">Trainer</option>
                    </select>
                </div>

                <!-- Position Input -->
                <div class="mb-3">
                    <label>Position</label>
                    <input type="text" name="position" class="form-control">
                </div>

                <!-- Salary Input -->
                <div class="mb-3">
                    <label>Salary (₹)</label>
                    <input type="text" name="salary" class="form-control">
                </div>

                <!-- Joining Date Picker -->
                <div class="mb-3">
                    <label>Joining Date</label>
                    <input type="date" name="joining_date" class="form-control">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    Generate Joining Letter
                </button>

            </form>

        </div>

    </div>

</div>

<?php 
// Include footer file (common footer section)
include 'footer.php'; 
?>