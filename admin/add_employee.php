<?php
include('../dbconfig.php');
require "../mail.php";

// If a session is not already started, start a new session
if(!session_id()){
    session_start(); 
} 

function generateRandomLetters() {
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $result = '';
    for ($i = 0; $i < 6; $i++) {
        $randomIndex = rand(0, strlen($letters) - 1);
        $result .= $letters[$randomIndex];
    }
    return $result;
}

if(count($_POST)) {
    $email = $_POST['email'];
    $role_id = 2;
    $password = generateRandomLetters();
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $firstname = $_POST['f-name'];
    $lastname = $_POST['l-name'];

    $stmt = $conn->prepare("CALL SP_ADD_EMPLOYEE(?, ?, ?, ?, ?)");
    $stmt->bind_param('ssiss', $email, $hash, $role_id, $firstname, $lastname);
    try{ 
        $stmt->execute();
        // Check for errors
        if ($stmt->errno) {
            $_SESSION['errorMessage'] = true;
            die('Failed to call stored procedure: ' . $stmt->error);
        } else {
            send_mail($email,"SAM: Account Creation", "Good day!<br><br>Your SAM email account is<br><br>Account Email: ".$email."<br>Password: ".$password."<br><br>Please note that this password is temporary and for security purposes, we require you to change it upon your first login.");
            $_SESSION['successMessage'] = true;
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['errorMessage'] = true;
    }
}
header('Location: admin_accounts.php');
exit();
?>