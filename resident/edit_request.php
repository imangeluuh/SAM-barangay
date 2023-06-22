<?php
print_r($_POST);
    include('../dbconfig.php');

    if(!session_id()){
        session_start(); 
    } 

    if(count($_POST)) { 
        // Fetch any remaining result sets
        while($conn->next_result()) {
            $conn->store_result();
        }
        if($_POST['document-type'] == 'barangay id') {
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
                $height = !empty($_POST['height']) ? $_POST['height'] : NULL;
                $weight = !empty($_POST['weight']) ? $_POST['weight'] : NULL;;
                $status = $_POST['status'];
                $religion = $_POST['religion'];
                $contact_name = $_POST['contact-name'];
                $contact_no = $_POST['contact-no'];
                $contact_address = $_POST['contact-address']; 
                $stmt = $conn->prepare("CALL SP_UPDATE_BRGY_ID(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('isddsssss', $_SESSION['docInfo']['doc_id'], $birthplace, $height, $weight, $status, $religion, $contact_name, $contact_address, $contact_no);
                // Execute the prepared statement
                $stmt->execute();    
            }
            // Close the prepared statement and database connection
            $stmt->close();
            $conn->close();
        } else if($_POST['document-type'] == 'certificate of indigency') { 
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
                $background_info = trim($_POST['background-info']);
                $purpose = trim($_POST['purpose']);

                $stmt = $conn->prepare("CALL SP_UPDATE_COI(?, ?, ?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('iss', $_SESSION['docInfo']['doc_id'], $background_info, $purpose);
                // Execute the prepared statement
                $stmt->execute();  
            }
            // Close the prepared statement and database connection
            $stmt->close();
            $conn->close();
        } else if($_POST['document-type'] == 'barangay clearance') {
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
                $background_info = trim($_POST['background-info']);
                $purpose = $_POST['purpose'];

                $stmt = $conn->prepare("CALL SP_UPDATE_CLEARANCE(?, ?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('is', $_SESSION['docInfo']['doc_id'], $purpose);
                // Execute the prepared statement
                $stmt->execute();  
            }
            // Close the prepared statement and database connection
            $stmt->close();
            $conn->close();
        }else if($_POST['document-type'] == 'business permit') { 
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
                $businessLine = $_POST['business-line']; 
                $businessAddress = $_POST['business-address']; 

                $stmt = $conn->prepare("CALL SP_UPDATE_PERMIT(?, ?, ?, ?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('isss', $_SESSION['docInfo']['doc_id'], $businessName, $businessLine, $businessAddress);
                // Execute the prepared statement
                $stmt->execute();  
            }
            // Close the prepared statement and database connection
            $stmt->close();
            $conn->close();
        }
    }
header("Location: view_docs.php");
exit();
?>