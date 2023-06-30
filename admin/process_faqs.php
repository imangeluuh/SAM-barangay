<?php
    include('../dbconfig.php');

    if(isset($_POST['save'])) {
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $f_question = $_POST['f_question'];
        $f_answer = $_POST['f_answer'];
        $stmt = $conn->prepare("CALL SP_ADD_FAQ(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $question, $answer, $f_question, $f_answer);
        $stmt->execute();
    }

    if(isset($_POST['edit'])) {
        $faq_id = $_POST['faq_id'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $f_question = $_POST['f_question'];
        $f_answer = $_POST['f_answer'];
        $stmt = $conn->prepare("CALL SP_UPDATE_FAQ(?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $faq_id, $question, $answer, $f_question, $f_answer);
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