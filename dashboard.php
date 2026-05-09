<?php
session_start();
include 'db.php';

// 🔐 PROTECT PAGE
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
// Include database connection
include 'db.php';

/* ================== DASHBOARD DATA ================== */

// Get total number of members
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM members");
$stmt->execute();
$totalMembers = $stmt->fetch(PDO::FETCH_ASSOC);

// Get total active members
$stmt_active = $pdo->prepare("SELECT COUNT(*) AS active_total FROM members WHERE status='active'");
$stmt_active->execute();
$active = $stmt_active->fetch(PDO::FETCH_ASSOC);

// Get total inactive members
$stmt_inactive = $pdo->prepare("SELECT COUNT(*) AS inactive_total FROM members WHERE status='inactive'");
$stmt_inactive->execute();
$inactive = $stmt_inactive->fetch(PDO::FETCH_ASSOC);

// Fetch latest 5 members
$stmt_recent = $pdo->prepare("SELECT id, name, email, status FROM members ORDER BY id DESC LIMIT 5");
$stmt_recent->execute();
$members = $stmt_recent->fetchAll(PDO::FETCH_ASSOC);

// Count total enquiries
$stmt_enquiries = $pdo->prepare("SELECT COUNT(*) AS total_enquiries FROM enquiries");
$stmt_enquiries->execute();
$enquiries = $stmt_enquiries->fetch(PDO::FETCH_ASSOC);

/* ================== ADMIN PROFILE ================== */

// Get admin ID from session
$admin_id = $_SESSION['admin_id'] ?? 0;

// Fetch admin details from database
$stmt_admin = $pdo->prepare("SELECT * FROM admins WHERE id = :id");
$stmt_admin->execute(['id' => $admin_id]);
$adminData = $stmt_admin->fetch(PDO::FETCH_ASSOC) ?? [];



// Include header file
include 'header.php';
?>


<style>
    .dashboard-card {
        border-radius: 16px;
        transition: 0.3s;
        overflow: hidden;
        position: relative;
    }

    .dashboard-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .dashboard-card::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 5px;
        bottom: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.3);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #43e97b, #38f9d7);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6d365, #fda085);
    }

    .bg-gradient-dark {
        background: linear-gradient(135deg, #434343, #000);
    }

    .card h2 {
        font-weight: bold;
        letter-spacing: 1px;
    }

    .badge {
        font-size: 12px;
        padding: 6px 10px;
    }

    .btn:hover {
        transform: scale(1.05);
        transition: 0.2s;
    }
</style>

<div class="dashboard-section">
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 p-0 sidebar-area">
                <?php include 'sidebar.php'; ?>
            </div>

            <!-- Main Dashboard Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <div class="row">

                    <!-- LEFT SIDE -->
                    <div class="col-lg-8">

                        <!-- Top Bar -->
                        <div
                            class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                            <h6 id="clock" class="text-end"></h6>

                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            $hour = date("H");
                            $greeting = ($hour < 12) ? "Good Morning" : (($hour < 17) ? "Good Afternoon" : "Good Evening");
                            ?>
                            <div>
                                <h5 class="mb-0">
                                    <?= htmlspecialchars($greeting . ' ' . ($_SESSION['admin'] ?? 'Admin')); ?> 👋
                                </h5>
                                <small class="text-muted">Welcome back</small>
                            </div>

                            <div class="w-50">
                                <input type="text" id="searchInput" class="form-control"
                                    placeholder="Search members...">
                            </div>

                            <div>
                                <a href="enquiries.php" class="btn btn-danger position-relative me-2">
                                    <i class="bi bi-bell fs-4"></i>
                                    <span id="notificationCount"
                                        class="position-absolute top-0 start-100 translate-middle badge bg-light text-danger">0</span>
                                </a>
                            </div>
                        </div>

                        <!-- Dashboard Cards -->
                        <section>
                            <div class="row g-4">

                                <!-- Total Members -->
                                <div class="col-lg-6">
                                    <div class="card text-white dashboard-card bg-gradient-primary">
                                        <div class="card-body d-flex justify-content-between">
                                            <div>
                                                <h6>Total Members</h6>
                                                <h2><?= $totalMembers['total'] ?? 0; ?></h2>
                                                <small>+5 this week</small>
                                            </div>
                                            <i class="bi bi-people-fill fs-1"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Active Members -->
                                <div class="col-lg-6">
                                    <div class="card text-white dashboard-card bg-gradient-success">
                                        <div class="card-body d-flex justify-content-between">
                                            <div>
                                                <h6>Active Members</h6>
                                                <h2><?= $active['active_total'] ?? 0; ?></h2>
                                                <small>Currently training</small>
                                            </div>
                                            <i class="bi bi-person-check-fill fs-1"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Inactive Members -->
                                <div class="col-lg-6">
                                    <div class="card text-dark dashboard-card bg-gradient-warning">
                                        <div class="card-body d-flex justify-content-between">
                                            <div>
                                                <h6>Inactive Members</h6>
                                                <h2><?= $inactive['inactive_total'] ?? 0; ?></h2>
                                                <small>Need follow-up</small>
                                            </div>
                                            <i class="bi bi-hourglass-split fs-1"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Enquiries -->
                                <div class="col-lg-6">
                                    <div class="card text-white dashboard-card bg-gradient-dark">
                                        <div class="card-body d-flex justify-content-between">
                                            <div>
                                                <h6>Total Enquiries</h6>
                                                <h2><?= $enquiries['total_enquiries'] ?? 0; ?></h2>
                                                <small>New leads</small>
                                            </div>
                                            <i class="bi bi-chat-dots-fill fs-1"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Activity Progress -->
                            <div class="card mt-4 shadow-sm">
                                <div class="card-body">
                                    <h6>Gym Activity</h6>
                                    <?php
                                    $percentage = ($totalMembers['total'] ?? 0) > 0
                                        ? ($active['active_total'] / $totalMembers['total']) * 100
                                        : 0;
                                    ?>
                                    <div class="progress mt-2" style="height: 10px;">
                                        <div class="progress-bar bg-success" style="width: <?= round($percentage) ?>%">
                                        </div>
                                    </div>
                                    <small><?= round($percentage) ?>% Active Members</small>
                                </div>
                            </div>
                        </section>


                        <!-- Recent Members Table -->
                        <section>
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5>Recent Members</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recentMembersTable"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>

                    <!-- RIGHT SIDE (Admin Profile) -->
                    <div class="col-lg-4">

                        <!-- Profile Card -->
                        <section>
                            <div class="card-body text-center">
                                <img src="images/<?= htmlspecialchars($adminData['profile_pic'] ?? 'profilepic.jpg'); ?>"
                                    class="rounded-circle mb-3 border border-3 border-primary" width="80" height="80">
                                <h5 class="mb-1"><?= htmlspecialchars($adminData['username'] ?? 'Admin'); ?></h5>
                                <p class="text-muted"><?= htmlspecialchars($adminData['status'] ?? 'Administrator'); ?>
                                </p>
                                <hr>
                                <div class="row text-center">
                                    <div class="col">
                                        <h6><?= htmlspecialchars($adminData['age'] ?? '-'); ?></h6><small>Age</small>
                                    </div>
                                    <div class="col">
                                        <h6><?= htmlspecialchars($adminData['role'] ?? '-'); ?></h6><small>Role</small>
                                    </div>
                                    <div class="col">
                                        <h6><?= htmlspecialchars($adminData['position'] ?? '-'); ?></h6>
                                        <small>Position</small>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Calendar -->
                        <section>
                            <div class="card shadow-sm">
                                <div class="card-header text-center">
                                    <h6>Calendar</h6>
                                </div>
                                <div class="card-body text-center">
                                    <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </section>
                        <!-- Quick Actions / Mini Dashboard -->
                        <section class="mt-4">
                            <div class="card shadow-sm">
                                <div class="card-header text-center bg-primary text-white">
                                    <h6>Quick Actions</h6>
                                </div>
                                <div class="card-body d-grid gap-2">
                                    <a href="members.php" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-person-plus"></i> Add Member
                                    </a>
                                    <a href="payment.php" class="btn btn-outline-success btn-sm w-100">
                                        <i class="bi bi-cash-stack"></i> Record Payment
                                    </a>
                                    <a href="attain.php" class="btn btn-outline-warning btn-sm w-100 text-dark">
                                        <i class="bi bi-calendar-check"></i> Attendance
                                    </a>
                                    <a href="members.php" class="btn btn-outline-info btn-sm w-100 text-dark">
                                        <i class="bi bi-people"></i> Members
                                    </a>
                                    <a href="trainer.php" class="btn btn-outline-secondary btn-sm w-100">
                                        <i class="bi bi-person-badge"></i> Trainers
                                    </a>
                                    <a href="enquiries.php" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-envelope"></i> Enquiries
                                    </a>
                                    <a href="settings.php" class="btn btn-outline-dark btn-sm w-100">
                                        <i class="bi bi-gear"></i> Settings
                                    </a>
                                </div>
                            </div>
                        </section>
                        <!-- Mini Payment Summary -->
                        <section class="mt-4">
                            <div class="card shadow-sm">
                                <div class="card-header text-center bg-success text-white">
                                    <h6>Payment Summary</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Fetch payment stats
                                    $stmt_total = $pdo->prepare("SELECT COUNT(*) AS total_payments, SUM(amount) AS total_amount FROM payments");
                                    $stmt_total->execute();
                                    $paymentSummary = $stmt_total->fetch(PDO::FETCH_ASSOC);

                                    $stmt_pending = $pdo->prepare("SELECT COUNT(*) AS pending_count FROM payments WHERE status='pending'");
                                    $stmt_pending->execute();
                                    $pendingPayments = $stmt_pending->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <p>Total Payments: <strong><?= $paymentSummary['total_payments'] ?? 0 ?></strong>
                                    </p>
                                    <p>Total Amount: <strong>₹<?= $paymentSummary['total_amount'] ?? 0 ?></strong></p>

                                </div>
                            </div>
                        </section>



                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Notifications
    function loadNotifications() {
        fetch('fetch_notifications.php')
            .then(res => res.json())
            .then(data => { document.getElementById('notificationCount').innerText = data.count; });
    }
    loadNotifications();
    setInterval(loadNotifications, 5000);

    // Live search members
    function loadMembers(query = "") {
        fetch('search_members.php?query=' + encodeURIComponent(query))
            .then(res => res.text())
            .then(data => document.getElementById('recentMembersTable').innerHTML = data)
            .catch(err => console.error("Error:", err));
    }
    window.onload = function () { loadMembers(); };
    document.getElementById('searchInput').addEventListener('keyup', function () { loadMembers(this.value); });

    // Real-time clock
    function updateClock() {
        let now = new Date();
        document.getElementById("clock").innerText = now.toLocaleTimeString();
    }
    setInterval(updateClock, 1000);
    updateClock();

    
</script>

<?php include 'footer.php'; ?>