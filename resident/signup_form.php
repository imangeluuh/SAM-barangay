<?php
    if(!session_id()) {
        session_start();
    }
    
    include('../dbconfig.php');

    if(count($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rpassword = $_POST['rpassword'];
        $role_id = 3;
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $res_firstname = $_POST['f-name'];
        $res_middlename = !empty($_POST['md-name']) ? $_POST['md-name'] : NULL;
        $res_lastname = $_POST['l-name'];
        $birthdate = $_POST['birthdate'];
        $address = $_POST['address'];
        
        // create a DateTime object from the birthdate string
        $birthday = new DateTime($birthdate);
        // get the current date
        $today = new DateTime(date('m.d.y'));
        // calculate the difference between the birthdate and the current date
        $diff = $today->diff($birthday);
        // get the age in years
        $age = $diff->y;
        
        if ($age < 18){
            $_SESSION['status'] = 'invalid age';
        } else if($password == $rpassword) {
            // Call the stored procedure
            $stmt = $conn->prepare("CALL SP_ADD_RESIDENT(?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssisssss', $email, $hash, $role_id, $res_firstname, $res_middlename, $res_lastname, $birthdate, $address);
            try{ 
                $stmt->execute();
                // Check for errors
                if ($stmt->errno) {
                    $_SESSION['status'] = 'existing email';
                    die('Failed to call stored procedure: ' . $stmt->error);
                } else {
                    header("Location:res_login.php?success=true"); 
                    exit();
                }

            } catch (mysqli_sql_exception $e) {
                $_SESSION['status'] = 'existing email';
            }
            // Close the statement and the connection
            $stmt->close();
            $conn->close();
        } else {
            $_SESSION['status'] = 'unmatched password';
        }
    }

    header('Location: ./res_signup.php');
    exit();
?>