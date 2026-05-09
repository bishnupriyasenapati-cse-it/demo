<?php
// Start session to track logged-in admin
session_start();

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Include database connection
include 'db.php';

// Fetch total check-ins for today
$stmt = $pdo->prepare("
    SELECT COUNT(*) AS total 
    FROM attendance 
    WHERE DATE(checkin_time) = CURDATE()
");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Include header layout
include 'header.php';
?>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar Section -->
        <div class="col-lg-2">
            <?php include 'sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="col-lg-10">
            <h2 class="mb-4">📋 Attendance Dashboard</h2>

            <!-- Total Check-ins Card -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card shadow border-0 rounded-4 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Total Check-ins Today</h6>
                                <!-- Display total check-ins -->
                                <h2 class="fw-bold text-primary"><?= $row['total']; ?></h2>
                            </div>
                            <div class="bg-primary text-white rounded-circle p-3">
                                <i class="bi bi-people-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="row mt-4 g-3">
                <!-- Search input -->
                <div class="col-md-6">
                    <input type="text" id="search" class="form-control shadow-sm" placeholder="🔍 Search member...">
                </div>

                <!-- Date filter -->
                <div class="col-md-3">
                    <input type="date" id="date" class="form-control shadow-sm">
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="card mt-4 shadow border-0 rounded-4">
                <div class="card-body">

                    <h5 class="mb-3">📋 Attendance List</h5>

                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Member</th>
                                    <th>name</th>
                                    <th>Check-in</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <!-- Data will be loaded dynamically here -->
                            <tbody id="attendanceTable"></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {

        // Initial load of attendance data
        loadAttendance();

        // Auto-refresh every 5 seconds
        setInterval(loadAttendance, 5000);

        // Trigger reload when search or date changes
        $("#search, #date").on("keyup change", loadAttendance);
    });

    // Function to fetch attendance data via AJAX
    function loadAttendance() {
        let search = $("#search").val();
        let date = $("#date").val();

        $.ajax({
            url: "fetch_attendance.php",
            type: "POST",
            data: { search: search, date: date },

            // Show loading message before request completes
            beforeSend: function () {
                $("#attendanceTable").html("<tr><td colspan='5'>Loading...</td></tr>");
            },

            // Update table with returned data
            success: function (data) {
                $("#attendanceTable").html(data);
            }
        });
    }

    // CHECK-IN button click handler
    $(document).on("click", ".checkinBtn", function () {
        let member_id = $(this).data("id");

        $.post("attendance_action.php", {
            member_id: member_id,
            action: "checkin"
        }, function (res) {
            alert(res); // Show response message
            loadAttendance(); // Refresh table
        });
    });

    // CHECK-OUT button click handler
    $(document).on("click", ".checkoutBtn", function () {
        let member_id = $(this).data("id");

        $.post("attendance_action.php", {
            member_id: member_id,
            action: "checkout"
        }, function (res) {
            alert(res); // Show response message
            loadAttendance(); // Refresh table
        });
    });
</script>

<?php 
// Include footer layout
include 'footer.php'; 
?>