<?php
include 'db.php';

// Fetch the dark mode setting from the database (id = 1)
$stmt = $pdo->prepare("SELECT dark_mode FROM settings WHERE id = 1");
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

// Determine if dark mode should be enabled
$darkMode = !empty($settings['dark_mode']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Gym Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <style>
        /* Dark mode styling */
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .dark-mode .card,
        .dark-mode .card-modern {
            background-color: #1e1e1e;
            color: #fff;
        }

        .dark-mode .form-control {
            background-color: #2a2a2a;
            color: #fff;
            border: 1px solid #444;
        }
    </style>
</head>

<body class="<?= $darkMode ? 'dark-mode' : '' ?>">
    <section>
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand">FitZone Gym</a>
                <!-- You can add navigation links here -->
            </div>
        </nav>
    </section>