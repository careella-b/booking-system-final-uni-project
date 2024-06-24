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
 * If the "delete-client" form input was submitted via POST request.
 * 
 * Then clientID is retrieved from the input value and a DELETE query is executed
 * on the "booking_clients" table with the given clientID.
 * 
 * If the query executes successfully, then a success message shows and redirects a user to the "success.php" page.
 * Else, an error message shows.
 */
if(isset($_POST['delete-client']))
{
    $clientID = $_POST['delete-client'];
    try {
        $query = "DELETE
                  FROM booking_clients 
                  WHERE clientID=:clientID";
        $statement = $pdo->prepare($query);
        $data = [':clientID' => $clientID];
        $query_execute = $statement->execute($data);

        if($query_execute)
        {
            $_SESSION['message'] = "Delete Successfully";
            header("Location: ./success.php");
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Oops! Something went wrong. Please try again later.";
            header("Location: ./success.php");
            exit(0);
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
