<?php
ini_set("session.save_path", "/home/unn_w19015711/public_html/sessionData");

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./calendar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three Motion - Booking System</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./style/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Icon CSS -->
    <script src="https://kit.fontawesome.com/e311938f0a.js" crossorigin="anonymous"></script>

    <!-- Custom Script -->
    <script src="/script/script.js"></script>

</head>
<body>
    <!-- Start of nav -->
    <nav class="navbar navbar-expand-lg nav-bg">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.html">
                <img src="./assets/ThreeMotion_Logo_White.png" alt="three motion logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./calendar.php">Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./adduser.php">Add New Client</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./newproject.php">Add New Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./editClient.php">Clients</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of nav -->
    
    <div class="container success-section">
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <i class="fa-sharp fa-regular fa-circle-check"></i>
                <h1 class="success-title">Hurray!</h1>
                <p>The form was submitted successfully</p>
                <a href="./calendar.php"><button class="btn btn-lg px-5 btn-submit">OK</button></a></button>
            </div>
        </div>
    </div>
</body>
</html>