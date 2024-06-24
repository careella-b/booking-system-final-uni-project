<?php
ini_set("session.save_path", "/home/unn_w19015711/public_html/sessionData");

// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
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
</head>

<body>
    <!-- Start of nav -->
    <nav class="navbar navbar-expand-lg nav-bg">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">
                <img src="./assets/ThreeMotion_Logo_White.png" alt="three motion logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="./calendar.php">Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./adduser.php">Add New Client</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./newproject.php">Add New Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./clients.php">Clients</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of nav -->

    <!-- Log out button -->
    <p class="logout-container d-flex flex-row-reverse">
        <a href="./logout.php" class="btn btn-logout">Sign Out</a>
    </p>

    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- Include FullCalendar JS & CSS library -->
    <link href="./script/fullcalendar/lib/main.min.css" rel="stylesheet" />
    <script src="./script/fullcalendar/lib/main.js"></script>
    <script src="https://kit.fontawesome.com/e311938f0a.js" crossorigin="anonymous"></script>
    <script src=https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./script/script.js"></script>
</body>
</html>