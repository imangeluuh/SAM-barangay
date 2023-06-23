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
        $age = $_POST['res-age'];
        $precinctNo = !empty($_POST['precinct-no']) ? $_POST['precinct-no'] : NULL;
        $contact_name = $_POST['contact-name'];
        $relationship = $_POST['relationship'];
        $contact_no = $_POST['contact-no'];
        $contact_address = $_POST['contact-address']; 
        
        $stmt = $conn->prepare("CALL SP_ADD_BRGY_ID(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('ssssiissssi', $name, $address, $birthdate, $birthplace, $age, $precinctNo, $contact_name, $relationship, $contact_address, $contact_no, $_SESSION['userData']['resident_id']);
        // Execute the prepared statement
        $stmt->execute();   
        if ($stmt) {
            echo "<script>window.location.href = 'res_services.php?success=true&service=request';</script>";
            exit();
        }
    } else if($_POST['document-type'] == 'certificate of indigency'){
        $resName = $_POST['res-name'];
        $resAge = $_POST['res-age']; 
        $resAddress= $_POST['address'];
        $purpose = $_POST['purpose'];
        $imgContent = NULL;
        $fileName = basename($_FILES["image"]["name"]) == NULL ? NULL : basename($_FILES["image"]["name"]) ; 

        if($fileName != NULL){
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
        try {
            $stmt = $conn->prepare("CALL SP_ADD_COI(?, ?, ?, ?, ?, ?, ?)");
            // bind the input parameters to the prepared statement
            $stmt->bind_param('sissssi', $resName, $resAge, $resAddress, $purpose, $fileName, $imgContent, $_SESSION['userData']['resident_id']);
            // Execute the prepared statement
            $stmt->execute();    
            if ($stmt) {
                echo "<script>window.location.href = 'res_services.php?success=true&service=request';</script>";
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            $_SESSION['error_message'] = 'large file';
        }
    }else if($_POST['document-type'] == 'barangay clearance') {
        $resName = $_POST['res-name'];
        $resAge = $_POST['res-age']; 
        $resAddress= $_POST['address'];
        $purpose = $_POST['purpose'];
        $stmt = $conn->prepare("CALL SP_ADD_CLEARANCE(?, ?, ?, ?, ?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('sissi', $resName, $resAge, $resAddress, $purpose, $_SESSION['userData']['resident_id']);
        // Execute the prepared statement
        $stmt->execute();   

        if ($stmt) {
            echo "<script>window.location.href = 'res_services.php?success=true';</script>";
            exit();
        }
    }else if($_POST['document-type'] == 'business permit') {
        $businessOwner = $_POST['res-name'];
        $businessName = $_POST['business-name']; 
        $businessAddress = $_POST['business-address']; 
        $plateNo = !empty($_POST['plate-no']) ? $_POST['plate-no'] : NULL; 
        $status = $_POST['status']; 
        $stmt = $conn->prepare("CALL SP_ADD_PERMIT(?, ?, ?, ?, ?, ?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('sssssi', $businessOwner, $businessName, $businessAddress, $plateNo, $status, $_SESSION['userData']['resident_id']);
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