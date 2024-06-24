<?php 
// Include database configuration file  
require_once "./functions.php";
 
// Retrieve JSON from POST body 
$jsonStr = file_get_contents('php://input'); 
$jsonObj = json_decode($jsonStr); 
// print_r( $jsonObj);

if(isset($jsonObj->fetch_projects))
{
    // Fetch events from database 
    $sql = "SELECT * FROM booking_projects"; 
    $result = $pdo->query($sql);  
    $projectssArr = array();

    while($row = $result->fetch(PDO::FETCH_OBJ))
    { 
        array_push($projectssArr, $row);
    } 
    // Render event data in JSON format 
    echo json_encode($projectssArr);
}

if(isset($jsonObj->request_type))
{
    /**
     * Add event function
     * 
     * The code retrieves the necessary data from the JSON object (event start and end times, event title and description,
     * and project ID) and inserts this information into the database using a prepared statement.
     * If it's successful, then returns a JSON-encoded status message indicating success, otherwise, returns an error message.
     */
    if($jsonObj->request_type == 'addEvent'){ 
        $start = $jsonObj->start; 
        $end = $jsonObj->end; 
        
        $event_data = $jsonObj->event_data; 
        $eventTitle = !empty($event_data[0])?$event_data[0]:''; 
        $eventDesc = !empty($event_data[1])?$event_data[1]:''; 
        $projectID = !empty($event_data[2])?$event_data[2]:''; 
        
        if(!empty($eventTitle)){ 
            // Insert event data into the database 
            $sqlQ = "INSERT INTO booking_bookings (title,description,start,end,projectID) VALUES (?,?,?,?,?)"; 
            $stmt = $pdo->prepare($sqlQ); 
            $stmt->bindParam(1, $eventTitle, PDO::PARAM_STR);
            $stmt->bindParam(2, $eventDesc, PDO::PARAM_STR);
            $stmt->bindParam(3, $start, PDO::PARAM_STR);
            $stmt->bindParam(4, $end, PDO::PARAM_STR);
            $stmt->bindParam(5, $projectID, PDO::PARAM_STR);

            $insert = $stmt->execute(); 
    
            if($insert){ 
                $output = [ 
                    'status' => 1 
                ]; 
                echo json_encode($output); 
            } else { 
                echo json_encode(['error' => 'Event Add request failed!']); 
            } 
        } 

        /**
         * Edit event function
         * 
         * The code retrieves the necessary data from the JSON object (event start and end times, event title and description,
         * and project ID) and inserts this information into the database using a prepared statement.
         * If it's successful, then returns a JSON-encoded status message indicating success, otherwise, returns an error message.
         */
    } elseif($jsonObj->request_type == 'editEvent') { 
        $start = $jsonObj->start; 
        $end = $jsonObj->end; 
        $event_id = $jsonObj->event_id; 
    
        $event_data = $jsonObj->event_data; 
        $eventTitle = !empty($event_data[0])?$event_data[0]:''; 
        $eventDesc = !empty($event_data[1])?$event_data[1]:''; 
        
        if(!empty($eventTitle)){ 
            // Update event data into the database 
            $sqlQ = "UPDATE booking_bookings SET title=?,description=?,start=?,end=? WHERE id=?"; 
            $stmt = $pdo->prepare($sqlQ); 
        
            $stmt->bindParam(1, $eventTitle, PDO::PARAM_STR);
            $stmt->bindParam(2, $eventDesc, PDO::PARAM_STR);
            $stmt->bindParam(3, $start, PDO::PARAM_STR);
            $stmt->bindParam(4, $end, PDO::PARAM_STR);
            $stmt->bindParam(5, $event_id, PDO::PARAM_STR);

            $update = $stmt->execute(); 
    
            if($update){ 
                $output = [ 
                    'status' => 1 
                ]; 
                echo json_encode($output); 
            } else { 
                echo json_encode(['error' => 'Event Update request failed!']); 
            } 
        }

        /**
         * Delete event function
         * 
         * The code retrieves the necessary data from the JSON object (event start and end times, event title and description,
         * and project ID) and inserts this information into the database using a prepared statement.
         * If it's successful, then returns a JSON-encoded status message indicating success, otherwise, returns an error message.
         */
    } elseif($jsonObj->request_type == 'deleteEvent'){ 

        $id = $jsonObj->event_id; 
    
        $sql = "DELETE FROM booking_bookings WHERE id=$id"; 
        $delete = $pdo->query($sql); 
        if($delete) { 
            $output = [ 
                'status' => 1 
            ]; 
            echo json_encode($output); 
        } else { 
            echo json_encode(['error' => 'Event Delete request failed!']); 
        } 
    } 
}
