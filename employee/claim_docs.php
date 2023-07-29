<?php
include('../dbconfig.php');
 // Fetch any remaining result sets
while($conn->next_result()) {
    $conn->store_result();
}
if(isset($_POST['claimed'])){
$requestID = $_POST['request_id'];
$status = $_POST['status'];
$stmt = $conn->prepare("CALL SP_UPDATE_STATUS(?, ?, @p_date_completed)");
// bind the input parameters to the prepared statement
$stmt->bind_param('is', $requestID, $status);
// Execute the prepared statement
$stmt->execute();
}
header('Location: emp_homepage.php');
?>