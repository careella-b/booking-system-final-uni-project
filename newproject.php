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
                        <a class="nav-link active" href="./newproject.php">Add New Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./clients.php">Clients</a>
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
                <h1 class="form-title">Add a New Project</h1>
                <form class="add-form" action="addProject.php" method="post">
                    <div class="row mb-3">
                        <?php if (isset($_SESSION['messagae'])) : ?>
                            <h5 class="alert alert-success"><?= $_SESSION['message']; ?></h5>
                        <?php
                            unset($_SESSION['message']);
                        endif;
                        ?>
                        <div class="col">
                            <label for="projectName" class="form-label">Project Name</label>
                            <input type="text" name="projectName" class="form-control input-colour" id="projectNameInput">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="col">
                            <label for="projectType" class="form-label">Project Type</label>
                            <input type="text" name="projectType" class="form-control" id="projectTypeInput">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" name="startDate" placeholder="dd-mm-yyy" class="form-control" id="startDateInput">
                            <span class="invalid-feedback"></span>

                        </div>
                        <div class="col">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" name="endDate" placeholder="dd-mm-yyy" class="form-control" id="endDateInput">
                            <span class="invalid-feedback"></span>

                        </div>
                    </div>
                    <div class="row mb-3 mt-4">
                        <div class="col-4">
                            <div class="select-dropdown">
                                <select class="clientid-dropdown" name="clientID">
                                    <option value="">--Select Client--</option>
                                    <?php
                                    /**
                                     * The SQL query SELECT retrieves the clientID and firstName fields of all clients
                                     * in the booking_clients table.
                                     * 
                                     * Prepare the query for execution.
                                     * 
                                     * Fetchs each row of the result set as an associative array $result.
                                     * 
                                     * Inside a while loop, each row is used to generate an option element in HTML.
                                     * The value of the option element is the clientID, and the text inside the option
                                     * element is the firstName.
                                     * 
                                     * If the firstName query parameter is set and matches the current client's clientID,
                                     * then the selected attribute is added to the option element to pre-select it.
                                     */
                                    $query = "SELECT clientID, firstName
                                                  FROM booking_clients";
                                    $statement = $pdo->prepare($query);
                                    $statement->execute();
                                    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <option value="<?php echo $result['clientID'] ?>
                                        <?php if (isset($_REQUEST['firstName'])) {
                                            if ($_REQUEST['firstName'] === $result['clientID']) {
                                                echo "selected";
                                            }
                                        } ?>"><?php echo $result['firstName'] ?></option>"
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <button type="submit" name="add-project-btn" class="btn btn-lg px-5 btn-submit mt-2" type="submit">Save</button>
            </form>
        </div>
        </div>
    </section>
    <!-- End of main -->
</body>
</html>