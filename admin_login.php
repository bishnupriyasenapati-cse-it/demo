<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            overflow-x: hidden;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            border-radius: 15px;
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 38px;
            user-select: none;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row vh-100">

        <!-- LEFT PANEL -->
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-white"
             style="background: linear-gradient(135deg, #f3b8d5, #f00c45);">

            <div class="text-center px-4">
                <h1 class="fw-bold mb-3">🏋️ FitZone Gym</h1>

                <p class="lead">
                    Manage your gym efficiently with our smart Gym Management System.
                </p>

                <ul class="list-unstyled mt-4">
                    <li>✔ Member Management</li>
                    <li>✔ Trainer Tracking</li>
                    <li>✔ Attendance System</li>
                    <li>✔ Enquiry Management</li>
                </ul>
            </div>

        </div>

        <!-- RIGHT PANEL -->
        <div class="col-md-6 d-flex align-items-center justify-content-center bg-light">

            <div class="card shadow login-card p-3">

                <div class="card-header text-center bg-dark text-white">
                    <h4>Admin Login</h4>
                </div>

                <div class="card-body">

                    <div id="loginMsg"></div>

                    <form id="loginForm">

                        <!-- Username -->
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3 position-relative">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>

                            <span class="toggle-password" onclick="togglePassword()">👁️</span>
                        </div>

                        <button class="btn btn-primary w-100" id="loginBtn">
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
// Toggle password visibility
function togglePassword() {
    let pass = document.getElementById("password");
    pass.type = (pass.type === "password") ? "text" : "password";
}

// AJAX login
$("#loginForm").submit(function(e) {
    e.preventDefault();

    $("#loginBtn")
        .html('<span class="spinner-border spinner-border-sm"></span> Logging in...')
        .prop("disabled", true);

    $.ajax({
        url: "login_process.php",
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",

        success: function(res) {

            if (!res || res.status === "error") {
                $("#loginMsg").html('<div class="alert alert-danger">Invalid Login</div>');
                $("#loginBtn").html("Login").prop("disabled", false);
            } 
            else {
                $("#loginMsg").html('<div class="alert alert-success">Login Successful</div>');

                setTimeout(function() {
                    window.location.href = "dashboard.php";
                }, 1000);
            }
        },

        error: function() {
            $("#loginMsg").html('<div class="alert alert-danger">Server Error</div>');
            $("#loginBtn").html("Login").prop("disabled", false);
        }
    });
});
</script>

</body>
</html>