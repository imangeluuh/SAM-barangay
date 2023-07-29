<?php
    include('../dbconfig.php');

    if(!session_id()){
        session_start(); 
    } 

    if(count($_POST)) { 
        if(isset($_POST['datepicker']) && isset($_POST['time'])) {
            $date = DateTime::createFromFormat('m/d/Y', $_POST['datepicker']);
            $schedule = $date->format('Y-m-d') . " " . $_POST['time'];
            
            $stmt = $conn->prepare("CALL SP_UPDATE_REQUEST(?, ?)");
            // bind the input parameters to the prepared statement
            $stmt->bind_param('is', $_SESSION['docInfo']['request_id'], $schedule);
            // Execute the prepared statement
            $stmt->execute();  
            $_SESSION['docInfo']['schedule'] = $schedule;
        } else {
            $businessName = $_POST['business-name']; 
            $businessAddress = $_POST['business-address']; 

            $stmt = $conn->prepare("CALL SP_UPDATE_PERMIT(?, ?, ?)");
            // bind the input parameters to the prepared statement
            $stmt->bind_param('iss', $_SESSION['docInfo']['doc_id'], $businessName, $businessAddress);
            // Execute the prepared statement
            $stmt->execute();  
        }
        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    }
header("Location: view_permit.php");
exit();
?>