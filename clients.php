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
                        <a class="nav-link" href="./adduser.php">Add New Client</a>
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

    <!-- Start of main -->
    <section class="add-user-bg">
        <div class="container ">
            <div class="row d-flex justify-content-center align-items-center">
                <h1 class="form-title">Clients</h1>
                <div class="report-btn-container d-flex flex-row-reverse">
                    <a href="./generateReport.php" target="_blank" class="btn btn-sm report-btn">Generate PDF</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thread>
                            <tr>
                                <th>Client ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email Address</th>
                                <th>Company Name</th>
                                <th>Job Role</th>
                                <th>Phone Number</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thread>
                        <tbody>
                            <?php

                            /**
                             * Displaying information as a table about clients stored in a MySQL database.
                             * It retrieves all the clients from the database using a SELECT query and then iterates over
                             * the result set to populate the table rows. Each row displays the client's information in
                             * the corresponding columns.
                             * 
                             * The Edit button links to another PHP page for editing the client's information.
                             * While the Delete button submits a form to a PHP script for deleting the client's
                             * record from the database.
                             * The script also includes a button to generate a PDF report of the client data.
                             */
                            $query = "SELECT * FROM booking_clients";
                            $statement = $pdo->prepare($query);
                            $statement->execute();

                            $result = $statement->fetchAll(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                            if ($result) {
                                foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row->clientID; ?></td>
                                        <td><?= $row->firstName; ?></td>
                                        <td><?= $row->lastName; ?></td>
                                        <td><?= $row->email; ?></td>
                                        <td><?= $row->companyName; ?></td>
                                        <td><?= $row->jobRole; ?></td>
                                        <td><?= $row->phoneNumber; ?></td>
                                        <td>
                                            <a href="editClients.php?clientID=<?= $row->clientID; ?>" class="btn edit-btn">Edit</a>
                                        </td>
                                        <td>
                                            <form action="deleteClients.php" method="POST">
                                                <button type="submit" name="delete-client" value="<?= $row->clientID; ?>" class="btn delete-btn">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5">No Record Found</td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- End of main -->
</body>
</html>