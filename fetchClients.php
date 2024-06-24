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
 * If the update form has been submitted by checking if the "update-client-btn" variable has been set in the $_POST
 * superglobal array.
 * Then retrieves the updated client information from the $_POST superglobal array.
 */
if(isset($_POST['update-client-btn']))
{
    $clientID = $_POST['clientID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $companyName = $_POST['companyName'];
    $jobRole = $_POST['jobRole'];
    $phoneNumber = $_POST['phoneNumber'];

    /**
     * Prepares an SQL UPDATE statement to update the client information in the database.
     */
    try {
        $query = "UPDATE booking_clients SET firstName=:firstName, lastName=:lastName, email=:email, companyName=:companyName, jobRole=:jobRole, phoneNumber=:phoneNumber
        WHERE clientID=:clientID LIMIT 1";
        $statement = $pdo->prepare($query);

        $data = [
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':email' => $email,
            ':companyName' => $companyName,
            ':jobRole' => $jobRole,
            ':phoneNumber' => $phoneNumber,
            ':clientID' => $clientID
        ];
        $query_execute = $statement->execute($data);

        /**
         * If the query executes successfully, the script sets a success message in the $_SESSION superglobal
         * array and redirects the user to a success page.
         * If fails, an error message is shown.
         */
        if($query_execute)
        {
            $_SESSION['message'] = "Updated Successfully";
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
