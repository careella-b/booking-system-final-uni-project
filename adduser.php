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

// Define variables and initialize with empty values
$firstName = $lastName = $email = $companyName = $jobRole = $phoneNumber = "";
$firstName_err = $lastName_err = $email_err = $companyName_err = $jobRole_err = $phoneNumber_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate firstname
    if (empty(trim($_POST["firstName"]))) {
        $firstName_err = "Please enter your first name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["firstName"]))) {
        $firstName_err = "First name can only contain letters";
    } else {
        $firstName = trim($_POST["firstName"]);
    }

    // Validate lastname
    if (empty(trim($_POST["lastName"]))) {
        $lastName_err = "Please enter your Last name.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["lastName"]))) {
        $lastName_err = "Last name can only contain letters";
    } else {
        $lastName = trim($_POST["lastName"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"], FILTER_VALIDATE_EMAIL))) {
        $email_err = "Invalid email format";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate company name
    if (empty(trim($_POST["companyName"]))) {
        $companyName_err = "Please enter your companyName.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["companyName"]))) {
        $companyName_err = "Company name can only contain letters, numbers, and underscores.";
    } else {
        $companyName = trim($_POST["companyName"]);
    }

    // Validate job role
    if (empty(trim($_POST["jobRole"]))) {
        $jobRole_err = "Please enter your job role.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["jobRole"]))) {
        $jobRole_err = "Job role can only contain letters";
    } else {
        $jobRole = trim($_POST["jobRole"]);
    }

    // Validate phone number
    if (empty(trim($_POST["phoneNumber"]))) {
        $phoneNumber_err = "Please enter your phone number.";
    } elseif (!preg_match('/^[0-9]{11}+$/', trim($_POST["phoneNumber"]))) {
        $phoneNumber_err = "Invalid number format: numbers only";
    } else {
        $phoneNumber = trim($_POST["phoneNumber"]);
    }

    // Check input errors before inserting in database
    if (
        empty($firstName_err) && empty($lastName_err) && empty($email_err) &&
        empty($companyName_err) && empty($jobRole_err) && empty($phoneNumber_err)
    ) {

        // Prepare an insert statement
        $sql = "INSERT INTO booking_clients (firstName, lastName, email, companyName, jobRole, phoneNumber)
                VALUES (:firstName, :lastName, :email, :companyName, :jobRole, :phoneNumber)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":firstName", $param_firstName, PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $param_lastName, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":companyName", $param_companyName, PDO::PARAM_STR);
            $stmt->bindParam(":jobRole", $param_jobRole, PDO::PARAM_STR);
            $stmt->bindParam(":phoneNumber", $param_phoneNumber, PDO::PARAM_STR);

            // Set parameters
            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_email = $email;
            $param_companyName = $companyName;
            $param_jobRole = $jobRole;
            $param_phoneNumber = $phoneNumber;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: ./success.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three Motion - Booking System</title>

    <link rel="stylesheet" href="./style/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Icon CSS -->
    <script src="https://kit.fontawesome.com/e311938f0a.js" crossorigin="anonymous"></script>

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

    <!-- Start of main -->
    <section class="add-user-bg">
        <div class="container ">
            <div class="row d-flex justify-content-center align-items-center">
                <h1 class="form-title">Add a New Client</h1>
                <form class="add-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" name="firstName" class="form-control input-colour <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstName; ?>" id="firstNameInput">
                            <span class="invalid-feedback"><?php echo $firstName_err; ?></span>
                        </div>
                        <div class="col">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" name="lastName" class="form-control <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastName; ?>" id="lastNameInput">
                            <span class="invalid-feedback"><?php echo $lastName_err; ?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" id="emailInput">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>

                        </div>
                        <div class="col">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" name="companyName" class="form-control <?php echo (!empty($companyName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $companyName; ?>" id="companyNameInput">
                            <span class="invalid-feedback"><?php echo $companyName_err; ?></span>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="jobRole" class="form-label">Job Role</label>
                            <input type="text" name="jobRole" class="form-control <?php echo (!empty($jobRole_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobRole; ?>" id="jobRoleInput">
                            <span class="invalid-feedback"><?php echo $jobRole_err; ?></span>

                        </div>
                        <div class="col">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="number" name="phoneNumber" class="form-control <?php echo (!empty($phoneNumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phoneNumber; ?>" id="phoneNumberInput">
                            <span class="invalid-feedback"><?php echo $phoneNumber_err; ?></span>

                        </div>
                    </div>
                    <button class="btn btn-lg px-5 btn-submit" type="submit">Save</button>
                </form>
            </div>
        </div>
    </section>
     <!-- End of main -->
</body>
</html>