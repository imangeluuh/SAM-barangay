<?php
    include('../dbconfig.php');

    if(isset($_POST['save'])) {
        $image = $_POST['image'];
        $stmt = $conn->prepare("CALL SP_ADD_CCHARTER(?)");
        $stmt->bind_param("s", $image);
        $stmt->execute();
    }

    if(isset($_POST['edit'])) {
        $image_id = $_POST['image_id'];
        $image = $_POST['image'];
        $stmt = $conn->prepare("CALL SP_UPDATE_CCHARTER(?, ?)");
        $stmt->bind_param("is", $image_id, $image);
        $stmt->execute();
    }

    if(isset($_POST['delete'])) {
        $image_id = $_POST['image_id'];
        $stmt = $conn->prepare("CALL SP_DELETE_CCHARTER(?)");
        $stmt->bind_param("i", $image_id);
        $stmt->execute();
    }
    echo "<script>window.location.href = 'content_management.php';</script>";
    exit();
?>