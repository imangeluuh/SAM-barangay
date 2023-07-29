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
            $civilStatus = $_POST['civil-status'];
            $nationality = $_POST['nationality'];
            $purpose = $_POST['purpose'];

            $stmt = $conn->prepare("CALL SP_UPDATE_CLEARANCE(?, ?, ?, ?)");
            // bind the input parameters to the prepared statement
            $stmt->bind_param('isss', $_SESSION['docInfo']['doc_id'], $civilStatus, $nationality, $purpose);
            // Execute the prepared statement
            $stmt->execute();  
        }
        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    }
header("Location: view_clearance.php");
exit();
?>