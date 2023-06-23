<?php
include('../dbconfig.php');

if(!session_id()){
    session_start(); 
}

if(count($_POST)) { 
    // Fetch any remaining result sets
    while($conn->next_result()) {
        $conn->store_result();
    }
    $status = $_POST['status'];
    $stmt = $conn->prepare("CALL SP_UPDATE_STATUS(?, ?, @p_date_completed)");
    // bind the input parameters to the prepared statement
    $stmt->bind_param('is', $_SESSION['docInfo']['request_id'], $status);
    // Execute the prepared statement
    $stmt->execute();
    // Fetch the output parameter value
    $result = $conn->query("SELECT @p_date_completed");
    $row = $result->fetch_assoc();
    $_SESSION['docInfo']['status'] = $status;
    $_SESSION['docInfo']['date_completed'] = $row['@p_date_completed'] == NULL ? 'N/A' : $row['@p_date_completed'];
    
    // update date issude and expiry date
    if($status == 'Ready for pick-up' && $_SESSION['docInfo']['document_type'] == 'Barangay ID') {
        while($conn->next_result()) {
            $conn->store_result();
        }                    
        $stmt = $conn->prepare("CALL SP_COMPLETE_BRGY_ID(?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('i', $_SESSION['docInfo']['doc_id']);
        // Execute the prepared statement
        $stmt->execute();
    } 
    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
    
    header("Location: view_docs.php");
    exit();
}
?>