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
        } else {
            $birthplace = $_POST['birthplace'];
            $precinctNo = !empty($_POST['precinct-no']) ? $_POST['precinct-no'] : NULL;
            $contact_name = $_POST['contact-name'];
            $relationship = $_POST['relationship'];
            $contact_no = $_POST['contact-no'];
            $contact_address = $_POST['contact-address']; 
            $stmt = $conn->prepare("CALL SP_UPDATE_BRGY_ID(?, ?, ?, ?, ?, ?, ?)");
            // bind the input parameters to the prepared statement
            $stmt->bind_param('isissss', $_SESSION['docInfo']['doc_id'], $birthplace, $precinctNo, $contact_name, $relationship, $contact_address, $contact_no);
            // Execute the prepared statement
            $stmt->execute();    
        }
        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    }
header("Location: view_id.php");
exit();
?>