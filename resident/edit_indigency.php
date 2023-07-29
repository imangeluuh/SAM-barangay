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
            $purpose = trim($_POST['purpose']);
            $imgContent = $_SESSION['docInfo']['requirements'];
            $fileName = basename($_FILES["image"]["name"]) == NULL ? $_SESSION['docInfo']['file_name'] : basename($_FILES["image"]["name"]) ; 
            if($fileName != NULL && $fileName != $_SESSION['docInfo']['file_name']){
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg'); 
                if(!in_array($fileType, $allowTypes)){ 
                    $_SESSION['error_message'] = 'invalid format';
                    header("Location: {$_SERVER['HTTP_REFERER']}");
                    exit();
                } else {
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = file_get_contents($image);
                }
            }
            $stmt = $conn->prepare("CALL SP_UPDATE_COI(?, ?, ?, ?)");
            // bind the input parameters to the prepared statement
            $stmt->bind_param('isss', $_SESSION['docInfo']['doc_id'], $purpose, $fileName, $imgContent);
            // Execute the prepared statement
            $stmt->execute();  
        }
        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    }
header("Location: view_indigency.php");
exit();
?>