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
 * Using FPDF library to create a new PDF document object and adding a new page to the PDF with no margin.
 */
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage('0');


/**
 * Code for print Heading of tables
 * 
 * Retrieves the column names of the booking_clients table from the database and uses them as headers for a PDF file
 */
$pdf->SetFont('Arial','B',12);	
$sql ="SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='unn_w19015711' AND `TABLE_NAME`='booking_clients'";
$query1 = $pdo -> prepare($sql);
$query1->execute();
$header=$query1->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query1->rowCount() > 0)
{
	foreach($header as $heading) {
		foreach($heading as $column_heading)
			$pdf->Cell(40,10,$column_heading,1);
	}
}

/**
 * Code for print data
 * 
 * Using the FPDF library to generate a PDF document containing data from a MySQL database table called "booking_clients".
 * Retrieves the data from the table and adds each row of data to the PDF document.
 */
$sql = "SELECT clientID, firstName, lastName, email, companyName, jobRole, phoneNumber from booking_clients ";
$query = $pdo -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
	foreach($results as $row) {
		$pdf->SetFont('Arial','',10);	
		$pdf->Ln();
		foreach($row as $column)
			$pdf->Cell(40,10,$column,1);
	} 
}
$pdf->Output();
