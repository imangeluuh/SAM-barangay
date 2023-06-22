<?php
include('../dbconfig.php');
if(!session_id()){
    session_start(); 
} 
if(isset($_POST['submit'])) {
    if($_POST['document-type'] == 'barangay id') {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $birthdate = $_POST['birthdate'];
        $birthplace = $_POST['birthplace'];
        $height = !empty($_POST['height']) ? $_POST['height'] : NULL;
        $weight = !empty($_POST['weight']) ? $_POST['weight'] : NULL;;
        $status = $_POST['status'];
        $religion = $_POST['religion'];
        $contact_name = $_POST['contact-name'];
        $contact_no = $_POST['contact-no'];
        $contact_address = $_POST['contact-address']; 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
        
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg'); 
        if(!in_array($fileType, $allowTypes)){ 
            $_SESSION['error_message'] = 'invalid format';
            // echo "<script>document.addEventListener('DOMContentLoaded', function() { invalidFormat(); });</script>";
        } else {
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = file_get_contents($image);
            try {
                $stmt = $conn->prepare("CALL SP_ADD_BRGY_ID(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('ssssssddssssi', $name, $address, $birthdate, $birthplace, $status, $religion, $height, $weight, $contact_name, $contact_address, $contact_no, $imgContent, $_SESSION['userData']['resident_id']);
                // Execute the prepared statement
                $stmt->execute();   
                if ($stmt) {
                    echo "<script>window.location.href = 'res_services.php?success=true&service=request';</script>";
                    exit();
                }
            } catch (mysqli_sql_exception $e) {
                // echo "<script>document.addEventListener('DOMContentLoaded', function() { largeFile(); });</script></script>";
                $_SESSION['error_message'] = 'large file';
            }
        }
    } else if($_POST['document-type'] == 'certificate of indigency'){
        $resName = $_POST['res-name'];
        $resAge = $_POST['res-age']; 
        $resAddress= $_POST['address'];
        $purpose = $_POST['purpose'];
        
        $stmt = $conn->prepare("CALL SP_ADD_COI(?, ?, ?, ?, ?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('sissi', $resName, $resAge, $resAddress, $purpose, $_SESSION['userData']['resident_id']);
        // Execute the prepared statement
        $stmt->execute();   
        if ($stmt) {
            echo "<script>window.location.href = 'res_services.php?success=true';</script>";
            exit();
        }
    }else if($_POST['document-type'] == 'barangay clearance') {
        $resName = $_POST['res-name'];
        $purpose = $_POST['purpose']; 
        $stmt = $conn->prepare("CALL SP_ADD_CLEARANCE(?, ?, ?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('ssi', $resName, $purpose, $_SESSION['userData']['resident_id']);
        // Execute the prepared statement
        $stmt->execute();   

        if ($stmt) {
            echo "<script>window.location.href = 'res_services.php?success=true';</script>";
            exit();
        }
    }else if($_POST['document-type'] == 'business permit') {
        $businessOwner = $_POST['res-name'];
        $businessName = $_POST['business-name']; 
        $businessLine = $_POST['business-line']; 
        $businessAddress = $_POST['business-address']; 
        $stmt = $conn->prepare("CALL SP_ADD_PERMIT(?, ?, ?, ?, ?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('ssssi', $businessOwner, $businessName, $businessLine, $businessAddress, $_SESSION['userData']['resident_id']);
        // Execute the prepared statement
        $stmt->execute();   

        if ($stmt) {
            echo "<script>window.location.href = 'res_services.php?success=true';</script>";
            exit();
        }
    }
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>