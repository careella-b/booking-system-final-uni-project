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

/**
 * Checks if the 'add-project-btn' POST variable is set, indicating that the form has been submitted
 * Then retrieves the form data using the $_POST superglobal array and assigns the values to corresponding variables.
 */
if(isset($_POST['add-project-btn']))
{
    $projectName = $_POST['projectName'];
    $projectType = $_POST['projectType'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $clientID = $_POST['clientID'];

    try {
        // An SQL query to insert the form data into the 'booking_projects' table in the database
        $query = "INSERT INTO booking_projects (projectName, projectType, startDate, endDate, clientID)
                  VALUE (:projectName, :projectType, :startDate, :endDate, :clientID)";
        $statement = $pdo->prepare($query);

        $data = [
            ':projectName' => $projectName,
            ':projectType' => $projectType,
            ':startDate' => $startDate,
            ':endDate' => $endDate,
            ':clientID' => $clientID,
        ];
        $query_execute = $statement->execute($data);

        /**
         * Checks if the execution was successful. If it was, the user is redirected to a success page 
         * If not, then show an error message
         */
        if($query_execute)
        {
            $_SESSION['message'] = "Added Successfully";
            header('Location: ./success.php');
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Oops! Something went wrong. Please try again later.";
            header('Location: ./success.php');
            exit(0);
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>