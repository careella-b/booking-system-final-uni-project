<?php

ini_set( "session.save_path", "/home/unn_w19015711/public_html/sessionData" );

// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: ./index.php");
exit;
?>