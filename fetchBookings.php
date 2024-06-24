<?php      
// Include database configuration file  
require_once "./functions.php";

// Filter events by calendar date 
$where_sql = ''; 
if(!empty($_GET['start']) && !empty($_GET['end'])){ 
    $where_sql .= " WHERE start BETWEEN '".$_GET['start']."' AND '".$_GET['end']."' "; 
} 
 
// Fetch events from database 
$sql = "SELECT * FROM booking_bookings $where_sql"; 
$result = $pdo->query($sql);  
 
$eventsArr = array();
    while($row = $result->fetch(PDO::FETCH_OBJ)){ 
        array_push($eventsArr, $row);
    
} 
 
// Render event data in JSON format 
echo json_encode($eventsArr);
