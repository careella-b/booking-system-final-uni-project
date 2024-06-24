<?php
/**
 * Connects to a MySQL database using PDO (PHP Data Objects) and sets the error
 * mode to throw exceptions. It also defines constants for the database server name, username, password, and
 * database name, but these are not used in the connection code.
 */
		try {
            define('DB_SERVER', 'localhost');
            define('DB_USERNAME', 'root');
            define('DB_PASSWORD', '');
            define('DB_NAME', 'unn_w19015711');

			$pdo = new PDO( "mysql:host=localhost;dbname=unn_w19015711", "unn_w19015711", "QURBNDDE" );
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} 
		catch (PDOException $e) {
			die("ERROR: Could not connect. " . $e->getMessage());
		}
?>
