<?php 
// Include the header
include 'header.php';

// Start the session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Include database connection
include 'db.php'; 

// Fetch existing settings from the database
$stmt = $pdo->prepare("SELECT * FROM settings WHERE id = 1");
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- Custom CSS for settings page -->
<style>
    body {
        background: #f4f6f9;
    }

    .settings-title {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .card-modern {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .card-modern:hover {
        transform: translateY(-5px);
    }

    .card-header-modern {
        font-weight: 600;
        background: linear-gradient(45deg, #007bff, #00c6ff);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 12px 20px;
    }

    .form-control {
        border-radius: 10px;
    }

    .btn-modern {
        border-radius: 10px;
        padding: 8px 20px;
    }

    .icon-box {
        font-size: 20px;
        margin-right: 8px;
    }

    .toggle-card {
        padding: 10px;
        border-radius: 10px;
        background: #f8f9fa;
        margin-bottom: 10px;
    }
    .modern-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    border-radius: 10px;
    background: #f8f9fa;
    margin-bottom: 10px;
}

.nav-pills .nav-link {
    border-radius: 10px;
    padding: 8px 16px;
}

.nav-pills .nav-link.active {
    background: linear-gradient(45deg, #007bff, #00c6ff);
}

</style>

<div class="container-fluid py-4">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-lg-2">
            <?php include 'sidebar.php'; ?>
        </div>

        <!-- Main -->
        <div class="col-lg-10">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">⚙️ Settings</h3>
                <span class="text-muted">Manage your system preferences</span>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-4" id="settingsTabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#general">🏋️ General</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notifications">🔔 Notifications</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#security">🔐 Security</button>
                </li>
            </ul>

            <div class="tab-content">

                <!-- GENERAL -->
                <div class="tab-pane fade show active" id="general">
                    <div class="card modern-card p-4">
                        <h5 class="mb-3">🏋️ General Settings</h5>

                        <form id="generalSettingsForm">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Gym Name</label>
                                    <input type="text" name="gym_name" value="<?= $data['gym_name'] ?? '' ?>" class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?= $data['email'] ?? '' ?>" class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="<?= $data['phone'] ?? '' ?>" class="form-control">
                                </div>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary px-4">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- NOTIFICATIONS -->
                <div class="tab-pane fade" id="notifications">
                    <div class="card modern-card p-4">
                        <h5 class="mb-3">🔔 Notification Settings</h5>

                        <form id="notificationsForm">

                            <div class="setting-item">
                                <span>Email Notifications</span>
                                <input type="checkbox" name="email_notifications"
                                <?= !empty($data['email_notifications']) ? 'checked' : '' ?>>
                            </div>

                            <div class="setting-item">
                                <span>Class Reminders</span>
                                <input type="checkbox" name="class_reminders"
                                <?= !empty($data['class_reminders']) ? 'checked' : '' ?>>
                            </div>

                            <div class="setting-item">
                                <span>Payment Alerts</span>
                                <input type="checkbox" name="payment_alerts"
                                <?= !empty($data['payment_alerts']) ? 'checked' : '' ?>>
                            </div>

                            <div class="setting-item">
                                <span>🌙 Dark Mode</span>
                                <input type="checkbox" id="dark_mode_toggle"
                                <?= !empty($data['dark_mode']) ? 'checked' : '' ?>>
                            </div>

                            <div class="text-end mt-3">
                                <button class="btn btn-primary px-4">Save</button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- SECURITY -->
                <div class="tab-pane fade" id="security">
                    <div class="card modern-card p-4">
                        <h5 class="mb-3">🔐 Security</h5>

                        <form id="securityForm">

                            <div class="mb-3">
                                <label>Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                            </div>

                            <div class="text-end">
                                <button class="btn btn-danger px-4">Update Password</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<!-- JS Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// GENERAL SETTINGS FORM SUBMISSION
$('#generalSettingsForm').submit(function(e){
    e.preventDefault();
    $.post('update_settings.php', $(this).serialize(), function(res){
        alert(res); // Show response from server
    });
});

// NOTIFICATIONS FORM SUBMISSION
$('#notificationsForm').submit(function(e){
    e.preventDefault();
    $.post('update_notifications.php', $(this).serialize(), function(res){
        alert(res);
    });
});

// SECURITY FORM SUBMISSION
$('#securityForm').submit(function(e){
    e.preventDefault();

    let newPass = $('#new_password').val();
    let confirmPass = $('#confirm_password').val();

    if(newPass !== confirmPass){
        alert("Passwords do not match!");
        return;
    }

    $.post('update_security.php', $(this).serialize(), function(res){
        alert(res);
    });
});

// TOGGLE PASSWORD VISIBILITY
function togglePassword(id, btn){
    let input = document.getElementById(id);
    if(input.type === "password"){
        input.type = "text";
        btn.innerHTML = "🙈";
    } else {
        input.type = "password";
        btn.innerHTML = "👁";
    }
}

// DARK MODE TOGGLE
$(document).ready(function(){
    $('#dark_mode_toggle').change(function(){
        let darkMode = $(this).is(':checked') ? 1 : 0;

        // Update dark mode setting in database
        $.post('update_darkmode.php', { dark_mode: darkMode }, function(){
            // Apply dark mode instantly
            if(darkMode){
                $('body').addClass('dark-mode');
            } else {
                $('body').removeClass('dark-mode');
            }
        });
    });
});
</script>

<?php 
// Include footer
include 'footer.php'; 
?>