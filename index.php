<?php
ini_set("session.save_path", "/home/unn_w19015711/public_html/sessionData");

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: ./calendar.php");
  exit;
}

// Include config file
require_once "./functions.php";

// Define variables and initialize with empty values
$username = $passwordHash = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if username is empty
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username.";
  } else {
    $username = trim($_POST["username"]);
  }

  // Check if password is empty
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $passwordHash = trim($_POST["password"]);
  }

  // Validate credentials
  if (empty($username_err) && empty($password_err)) {
    // Prepare a select statement
    $sql = "SELECT userID, username, passwordHash FROM booking_users WHERE username = :username";

    if ($stmt = $pdo->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

      // Set parameters
      $param_username = trim($_POST["username"]);

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // Check if username exists, if yes then verify password
        if ($stmt->rowCount() == 1) {
          if ($row = $stmt->fetch()) {
            $userID = $row["userID"];
            $username = $row["username"];
            $hashed_password = $row["passwordHash"];
            if (password_verify($passwordHash, $hashed_password)) {
              // Password is correct, so start a new session
              session_start();

              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["userID"] = $userID;
              $_SESSION["username"] = $username;

              // Redirect user to welcome page
              header("location: ./calendar.php");
            } else {
              // Password is not valid, display a generic error message
              $login_err = "Invalid username or password.";
            }
          }
        } else {
          // Username doesn't exist, display a generic error message
          $login_err = "Invalid username or password.";
        }
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

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./style/style.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Icon CSS -->
  <script src="https://kit.fontawesome.com/e311938f0a.js" crossorigin="anonymous"></script>

</head>
<body>
  <!-- Start of Nav -->
  <nav class="navbar navbar-expand-lg nav-bg">
    <div class="container-fluid">
      <a class="navbar-brand" href="/index.php">
        <img src="./assets/ThreeMotion_Logo_White.png" alt="three motion logo" class="logo">
      </a>
    </div>
  </nav>
   <!-- End of Nav -->

   <!-- Start of main -->
  <section class="homepage-bg">
    <div class="container">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card text-light">
            <div class="card-body">
              <h1 class="login-title text-center">Login</h1>
              <p class="text-dark-50 mb-3 text-center">Please enter your login and password!</p>
              <?php
              if (!empty($login_err)) {
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
              }
              ?>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-outline form-dark mb-2">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" />
                  <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>

                <div class="form-outline form-dark mb-2">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" />
                  <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <button class="btn btn-lg px-5 btn-submit" type="submit">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End of main -->

</body>
</html>