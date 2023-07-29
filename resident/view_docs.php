<?php
ob_start();
// If a session is not already started, start a new session
if(!session_id()){
    session_start();
}
include('../dbconfig.php');

if(isset($_POST['view'])){
    // store the selected document data in session
    $docInfo = array('request_id' => $_POST['request_id']
                                , 'document_type' => $_POST['document_type']
                                , 'date_requested' => $_POST['date_requested']
                                , 'date_completed' =>  $_POST['date_completed'] == NULL ? 'N/A' : $_POST['date_completed']
                                , 'status' => $_POST['status']
                                , 'doc_id' => $_POST['doc_id']
                                , 'schedule' => $_POST['schedule']);
    // Store the user data array in the $_SESSION variable for future use.
    $_SESSION['docInfo'] = $docInfo;
}
if($_SESSION['docInfo']['document_type'] == 'Barangay ID') {
    header('Location: view_id.php');
} else if($_SESSION['docInfo']['document_type'] == 'Certificate of Indigency') {
    header('Location: view_indigency.php');
} else if($_SESSION['docInfo']['document_type'] == 'Barangay Clearance') {
    header('Location: view_clearance.php');
} else if($_SESSION['docInfo']['document_type'] == 'Business Permit') {
    header('Location: view_permit.php');
}
exit();
?>        