<?php $page = basename($_SERVER['PHP_SELF']); // Get current page name to highlight active menu ?>
<style>
    /* Style for sidebar links */
    .nav-link {
        border-radius: 8px;
        transition: 0.3s;
    }

    /* Hover effect for links */
    .nav-link:hover {
        background-color: #0d6efd;
        color: white !important;
        padding-left: 12px;
    }

    /* Active link styling */
    .nav-link.active {
        background-color: #0d6efd;
        color: white !important;
    }
</style>z

<section>
    <div class="d-flex flex-column justify-content-between bg-light p-3 shadow" style="width:220px; height:100vh;">

        <!-- TOP CONTENT: Logo and Navigation Menu -->
        <div>

            <!-- LOGO -->
            <div class="text-center mb-4">
                <img src="images/logo.png" class="img-fluid" style="max-height:80px;">
                <h5 class="mt-2 fw-bold">FitZone</h5>
            </div>

            <hr>

            <!-- Menu Title -->
            <h6 class="text-muted">MENU</h6>

            <!-- NAVIGATION LINKS -->
            <ul class="nav flex-column">

                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a href="dashboard.php"
                        class="nav-link text-dark <?= ($page == 'dashboard.php') ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <!-- Members Link -->
                <li class="nav-item">
                    <a href="members.php" class="nav-link text-dark <?= ($page == 'members.php') ? 'active' : '' ?>">
                        <i class="bi bi-people me-2"></i> Members
                    </a>
                </li>

                <!-- Trainers Link -->
                <li class="nav-item">
                    <a href="trainer.php" class="nav-link text-dark <?= ($page == 'trainer.php') ? 'active' : '' ?>">
                        <i class="bi bi-person-badge me-2"></i> Trainers
                    </a>
                </li>

                <!-- Attendance Link -->
                <li class="nav-item">
                    <a href="attain.php" class="nav-link text-dark <?= ($page == 'attain.php') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-check me-2"></i> Attendance
                    </a>
                </li>

                <!-- Membership Plan Link -->
                <li class="nav-item">
                    <a href="membership.php"
                        class="nav-link text-dark <?= ($page == 'membership.php') ? 'active' : '' ?>">
                        <i class="bi bi-card-checklist me-2"></i> Membership Plan
                    </a>
                </li>

                <!-- Enquiries Link -->
                <li class="nav-item">
                    <a href="enquiries.php"
                        class="nav-link text-dark <?= ($page == 'enquiries.php') ? 'active' : '' ?>">
                        <i class="bi bi-envelope me-2"></i> Enquiries
                    </a>
                </li>

                <!-- Certificates Link -->
                <li class="nav-item">
                    <a href="generate_certificate.php"
                        class="nav-link text-dark <?= ($page == 'generate_certificate.php') ? 'active' : '' ?>">
                        <i class="bi bi-award me-2"></i> Certificates
                    </a>
                </li>

                <!-- Joining Letter Link -->
                <li class="nav-item">
                    <a href="generate_joining_letter.php"
                        class="nav-link text-dark <?= ($page == 'generate_joining_letter.php') ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-text me-2"></i> Joining Letter
                    </a>
                </li>

                   <li class="nav-item">
                    <a href="payment.php"
                        class="nav-link text-dark <?= ($page == 'payment.php') ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-text me-2"></i> Make Payment
                    </a>
                </li>

                <!-- Settings Link -->
                <li class="nav-item">
                    <a href="settings.php" class="nav-link text-dark <?= ($page == 'settings.php') ? 'active' : '' ?>">
                        <i class="bi bi-gear me-2"></i> Settings
                    </a>
                </li>

            </ul>

        </div>

        <!-- BOTTOM CONTENT: Logout Button -->
        <div>
            <hr>
            <a href="logout.php" class="btn btn-danger w-100"
                onclick="return confirm('Are you sure you want to logout?')">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </div>

    </div>
</section>