<?php
    include('../dbconfig.php');

    if(isset($_POST['save'])) {
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $stmt = $conn->prepare("CALL SP_ADD_FAQ(?, ?)");
        $stmt->bind_param("ss", $question, $answer);
        $stmt->execute();
    }

    if(isset($_POST['edit'])) {
        $faq_id = $_POST['faq_id'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $stmt = $conn->prepare("CALL SP_UPDATE_FAQ(?, ?, ?)");
        $stmt->bind_param("iss", $faq_id, $question, $answer);
        $stmt->execute();
    }

    if(isset($_POST['delete'])) {
        $faq_id = $_POST['faq_id'];
        $stmt = $conn->prepare("CALL SP_DELETE_FAQ(?)");
        $stmt->bind_param("i", $faq_id);
        $stmt->execute();
    }
    echo "<script>window.location.href = 'content_management.php';</script>";
    exit();
?>