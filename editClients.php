<?php
ini_set("session.save_path", "/home/unn_w19015711/public_html/sessionData");

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./calendar.php");
    exit;
}

// Include config file
require_once "./functions.php";
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
                        <a class="nav-link" href="./adduser.php">Add New User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./newproject.php">Add New Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./clients.php">Clients</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of nav -->

    <!-- start of main -->
    <section class="add-user-bg">
        <div class="container ">
            <div class="row d-flex justify-content-center align-items-center">
                <h1 class="form-title">Edit Client</h1>

                <div class="card-body">
                    <?php
                    /**
                     * Checks if the clientID parameter is set in the URL query string.
                     * 
                     * If it is, assigns the value to the $clientID variable and queries the database to fetch the
                     * client record with that clientID.
                     * 
                     * The LIMIT 1 clause is used to ensure that only one record is returned, even if there are
                     * multiple records with the same clientID.
                     * 
                     * Then stores in the $result variable as an object with properties corresponding to the columns
                     * of the booking_clients table.
                     */
                    if (isset($_GET['clientID'])) {
                        $clientID = $_GET['clientID'];

                        $query = "SELECT * FROM booking_clients WHERE clientID=:clientID LIMIT 1";
                        $statement = $pdo->prepare($query);
                        $data = [':clientID' => $clientID];
                        $statement->execute($data);

                        $result = $statement->fetch(PDO::FETCH_OBJ);
                    }
                    ?>
                    <form action="fetchClients.php" method="POST">

                        <input type="hidden" name="clientID" value="<?= $result->clientID; ?>" />

                        <div class="mb-3">
                            <label class="edit-form-label">First Name</label>
                            <input type="text" name="firstName" value="<?= $result->firstName; ?>" class="form-control edit-form-input" />
                        </div>
                        <div class="mb-3">
                            <label class="edit-form-label">Last Name</label>
                            <input type="text" name="lastName" value="<?= $result->lastName; ?>" class="form-control edit-form-input" />
                        </div>
                        <div class="mb-3">
                            <label class="edit-form-label">Email Address</label>
                            <input type="text" name="email" value="<?= $result->email; ?>" class="form-control edit-form-input" />
                        </div>
                        <div class="mb-3">
                            <label class="edit-form-label">Company Name</label>
                            <input type="text" name="companyName" value="<?= $result->companyName; ?>" class="form-control edit-form-input" />
                        </div>
                        <div class="mb-3">
                            <label class="edit-form-label">Job Role</label>
                            <input type="text" name="jobRole" value="<?= $result->jobRole; ?>" class="form-control edit-form-input" />
                        </div>
                        <div class="mb-3">
                            <label class="edit-form-label">Phone Number</label>
                            <input type="text" name="phoneNumber" value="<?= $result->phoneNumber; ?>" class="form-control edit-form-input" />
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="update-client-btn" class="btn update-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End of main -->

</body>
</html>