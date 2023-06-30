<?php
    include('../dbconfig.php');

    if(isset($_POST['save'])) {
        $detail_name = $_POST['detail-name'];
        $details = $_POST['details'];
        $f_details = $_POST['f_details'];
        $stmt = $conn->prepare("CALL SP_ADD_SYSTEM_DETAILS(?, ?, ?)");
        $stmt->bind_param("sss", $detail_name, $details, $f_details);
        $stmt->execute();
    }

    if(isset($_POST['edit'])) {
        $detail_id = $_POST['detail_id'];
        $detail_name = $_POST['detail-name'];
        $details = $_POST['details'];
        $f_details = $_POST['f_details'];
        $stmt = $conn->prepare("CALL SP_UPDATE_SYSTEM_DETAILS(?, ?, ?, ?)");
        $stmt->bind_param("isss", $detail_id, $detail_name, $details, $f_details);
        $stmt->execute();
    }

    if(isset($_POST['delete'])) {
        $detail_id = $_POST['detail_id'];
        $stmt = $conn->prepare("CALL SP_DELETE_SYSTEM_DETAILS(?)");
        $stmt->bind_param("i", $detail_id);
        $stmt->execute();
    }
    echo "<script>window.location.href = 'content_management.php';</script>";
    exit();
?>