<?php
include('../dbconfig.php');

// If a session is not already started, start a new session
if(!session_id()){
    session_start(); 
} 

while($conn->next_result()) {
    $conn->store_result();
}
if(count($_POST)) {
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("CALL SP_UPDATE_REPORT_STATUS(?, ?)");
    // bind the input parameters to the prepared statement
    $stmt->bind_param('is', $_SESSION['reportInfo']['report_id'], $status);
    // Execute the prepared statement
    $stmt->execute();   
    
    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
    
    header("Location: view_report.php");
    exit();
}
?>