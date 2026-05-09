<!DOCTYPE html>
<html>

<head>
    <title>Gym Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<!-- HERO SECTION STYLES -->
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('images/banner img.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        align-items: center;
        color: white;
    }

    .card-img-top {
        height: 250px;
        object-fit: cover;
    }
    
</style>

<body>
    <!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">

            <!-- LOGO -->
            <a class="navbar-brand fw-bold" href="#">FitZone</a>

            <!-- MOBILE TOGGLE -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- MENU LINKS -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#programs">Programs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#trainers">Trainers</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white ms-2 px-3" href="#enquiry">
                            Join Now
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">

                <!-- LEFT TEXT -->
                <div class="col-lg-7">
                    <h1 class="display-4 fw-bold">Welcome to FitZone Gym</h1>
                    <p class="lead">Your Fitness Journey Starts Here</p>
                    <a href="#enquiry" class="btn btn-primary btn-lg mt-3">Join Now</a>
                </div>

                <!-- RIGHT ENQUIRY FORM -->
                <div class="col-lg-5" id="enquiry">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Send Enquiry</h5>
                        </div>
                        <div class="card-body">
                            <!-- Added an ID for JS AJAX submission -->
                            <form id="enquiryForm" action="send_enquiry.php" method="POST">
                                <input type="text" name="name" class="form-control mb-3" placeholder="Your Name"
                                    required>
                                <input type="email" name="email" class="form-control mb-3" placeholder="Email Address"
                                    required>
                                <input type="tel" name="phone" class="form-control mb-3" placeholder="Phone Number"
                                    required>
                                <textarea name="message" class="form-control mb-3" placeholder="Your Message"
                                    required></textarea>
                                <button class="btn btn-success w-100">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="container mt-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="images/gym home.jpg" class="img-fluid rounded shadow" alt="Gym Interior">
            </div>
            <div class="col-md-6">
                <h2>About Our Gym</h2>
                <h1>Your Ultimate Fitness Destination!</h1>
                <p>We provide professional fitness training, modern equipment, and certified trainers to help you
                    achieve your fitness goals. Join our community and start your fitness journey today.</p>
            </div>
        </div>
    </section>

    <!-- PROGRAMS SECTION -->
    <section id="programs" class="container mt-5 text-center">
        <h2>Our Programs</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5>Weight Training</h5>
                        <p>Build strength with expert trainers and modern equipment.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5>Yoga</h5>
                        <p>Improve flexibility, balance, and peace of mind.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5>Cardio Training</h5>
                        <p>Boost stamina and burn calories with cardio workouts.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TRAINERS SECTION -->
    <section id="trainers" class="container mt-5 text-center">
        <h2>Our Trainers</h2>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="images/fitness trainer.webp" class="card-img-top" alt="Fitness Trainer">
                    <div class="card-body">
                        <h5>Rahul Sharma</h5>
                        <p>Fitness Trainer</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="images/yoga trainer.jpg" class="card-img-top" alt="Yoga Trainer">
                    <div class="card-body">
                        <h5>Sangeeta K</h5>
                        <p>Yoga Trainer</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">

                <!-- LEFT TEXT -->
                <div class="col-lg-6">
                    <h2 class="mb-3">Why Choose FitZone Gym</h2>
                    <p>Join the best fitness community with certified trainers, modern equipment, and personalized
                        workout programs designed to help you reach your fitness goals faster.</p>
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">✔ Certified Trainers</div>
                        <div class="col-md-6 mb-3">✔ Modern Equipment</div>
                        <div class="col-md-6 mb-3">✔ Diet Consultation</div>
                        <div class="col-md-6 mb-3">✔ Flexible Timings</div>
                    </div>
                </div>

                <!-- RIGHT TABLE -->
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Gym Services</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th>Service</th>
                                    <th>Available</th>
                                </tr>
                                <tr>
                                    <td>Personal Training</td>
                                    <td class="text-success">✔ Yes</td>
                                </tr>
                                <tr>
                                    <td>Yoga Classes</td>
                                    <td class="text-success">✔ Yes</td>
                                </tr>
                                <tr>
                                    <td>Weight Training</td>
                                    <td class="text-success">✔ Yes</td>
                                </tr>
                                <tr>
                                    <td>Diet Consultation</td>
                                    <td class="text-success">✔ Yes</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CALL TO ACTION -->
    <section class="text-center py-5">
        <h2>Start Your Fitness Journey Today</h2>
        <p>Join FitZone Gym and transform your life.</p>
        <a href="#enquiry" class="btn btn-warning btn-lg">Join Now</a>
    </section>

    <!-- SMOOTH SCROLL & ENQUIRY FORM AJAX -->
    <script>
        // Smooth scroll for nav links
        document.querySelectorAll('a.nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                if (this.hash !== "") {
                    e.preventDefault();
                    document.querySelector(this.hash).scrollIntoView({ behavior: "smooth" });
                }
            });
        });

        // AJAX form submission for enquiry
        $("#enquiryForm").submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "send_enquiry.php",
                method: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    alert("Enquiry Sent Successfully!");
                    $("#enquiryForm")[0].reset();
                },
                error: function () {
                    alert("Something went wrong!");
                }
            });
        });
    </script>

    <!-- PHP FOOTER INCLUDE -->
    <!-- Including the footer section -->
    <?php include 'footer.php'; ?>

</body>

</html>