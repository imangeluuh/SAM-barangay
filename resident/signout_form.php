<?php
    include('../dbconfig.php');
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 

    if(isset($_POST['submit'])) {
        $rate = $_POST['rate'];
        if(isset($rate)) {
            $stmt = $conn->prepare('CALL SP_ADD_RATE(?)');
            $stmt->bind_param('i', $rate);
            $stmt->execute();
        }
    }
    
    session_destroy();
    header('Location: ../index.php');
    exit();
?>