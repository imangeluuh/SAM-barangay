<?php
    // Start session 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 

    // Include the database configuration file
    include('../dbconfig.php');

    require "../mail.php";

    $mode = "enter_email";
    
    if(isset($_GET['mode'])){
        $mode = $_GET['mode'];
    }

    if(count($_POST)) {
        switch($mode) {
            case 'enter_email':
                $email = $_POST['email'];
                if(find_email($email)){
                    $_SESSION['forgot']['email'] = $email;
                    send_email($email);
                    header("Location: forgot_pass.php?mode=enter_code");
                    die;
                } else {
                    echo "<script>alert('The email you entered isn\'t connected to an account.')</script>";
                }
                break;
            case 'enter_code':
                $code =  $_POST['code'];
                $result = is_code_correct($code);

                if($result == "The code is correct") {
                    $_SESSION['forgot']['code'] = $code;
                    header("Location: forgot_pass.php?mode=enter_password");
                    die;
                } else {
                    echo "<script>alert('$result'); window.location.href = 'forgot_pass.php?enter_email';</script>";
                }
                break;
            case 'enter_password':
                $password = $_POST['password'];
                $rpassword = $_POST['rpassword'];
                if($password !== $rpassword) { 
                    echo "<script>alert('Passwords do not match');history.go(-1);</script>";
                } elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code']) ) {
                    header("Location: forgot_pass.php");
                    die;
                } else {
                    save_password($password);

                    if(isset($_SESSION['forgot']))
                        unset($_SESSION['forgot']);

                    header("Location: res_login.php");
                    die;
                }
                break;
            default:
                break;
        }
    }

    function send_email($email){
        global $conn;
        $expire = time() + (60 * 3);
        $code = rand(10000,99999);
        $email = addslashes($email);


        // Call the stored procedure 
        $stmt = $conn->prepare("CALL SP_ADD_CODE(?, ?, ?)");

        // bind the input parameters to the prepared statement
        $stmt->bind_param('ssi', $email, $code, $expire);

        // Execute the prepared statement
        $stmt->execute();

        //send email
        send_mail($email,"SAM: Password Reset", "Your code is " . $code);
    }

    function is_code_correct($code){
        global $conn;
        $code = addslashes($code);
        $expire = time();
        $email = addslashes($_SESSION['forgot']['email']);

        // Call the stored procedure 
        $stmt = $conn->prepare("CALL SP_GET_CODE(?, ?)");

        // bind the input parameters to the prepared statement
        $stmt->bind_param('ss', $email, $code);

        // Execute the prepared statement
        $stmt->execute();

        // retrieve the result set from the executed statement
        $result = $stmt->get_result();  

        if($result) {   
            if(mysqli_num_rows($result)) {
                // fetch the row from the result set
                $row = $result->fetch_assoc();
                if($row['expire'] > $expire) {
                    return "The code is correct";
                } else {
                    return "Sorry, the code you entered has expired. Please request a new code.";
                }
            } else {
                return "The code you entered is incorrect. Please try again.";
            }
        }
        
        return false;
    }

    function find_email($email) {
        global $conn;
        // Call the stored procedure to retrieve user login information from the database
        $stmt = $conn->prepare("CALL SP_FIND_LOGIN(?)");

        // bind the input parameters to the prepared statement
        $stmt->bind_param('s', $email);

        // Execute the prepared statement
        $stmt->execute();

        // retrieve the result set from the executed statement
        $result = $stmt->get_result();  

        // fetch the row from the result set
        $row = $result->fetch_assoc();

        return (mysqli_num_rows($result) && $row['role_id'] == 3 );
    }

    function save_password($password){
        global $conn;
        $password = password_hash($password, PASSWORD_BCRYPT);
        $email = addslashes($_SESSION['forgot']['email']);

        // Call the stored procedure 
        $stmt = $conn->prepare("CALL SP_UPDATE_PASS(?, ?)");

        // bind the input parameters to the prepared statement
        $stmt->bind_param('ss', $email, $password);

        // Execute the prepared statement
        $stmt->execute();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS link -->
    <link rel="stylesheet" href="css/forgot_pass.css">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigi0n>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-fluid d-flex justify-content-center p-0">
        <div class="main-container d-flex align-items-center">
            <div class="login-form row d-flex justify-content-center rounded-4 p-0 m-0">
                <?php
                    switch($mode) {
                        case 'enter_email':
                        ?>  <p class="d-flex align-items-center px-5 mt-5 mb-4 p-0">
                            <i class="fas fa-solid fa-lock fs-5 me-3"></i>
                            Enter your email address and we'll send you a link to reset your password.
                            </p>
                            <div class="col-8 p-0">
                                <form action="forgot_pass.php?mode=enter_email" method="post">
                                    <!-- Email field -->
                                    <div class="form-outline row mb-3">
                                        <input type="text" name="email" id="email" class="form-control-lg border-0 rounded-3 border-dark-subtle" placeholder="E-mail" required="required">
                                    </div>
                                    <!-- Submit button -->
                                    <div class="text-center row justify-content-end mb-4">
                                        <input type="submit" value="Reset Password" name="reset" class="reset-button border-0 rounded-2 text-light py-1">
                                    </div>
                                </form>
                                <div class="container p-0 my-5">
                                    <span class="fw-light create-account  p-0">Don't have an account?</span>
                                    <a href="./res_signup.php" class="text-decoration-none p-0 sign-up">Sign-up</a>
                                </div>
                                
                            </div>
                        <?php    break;
                        case 'enter_code':
                        ?>  <p class="d-flex align-items-center px-5 mt-5 mb-4 p-0">
                            <i class="fas fa-solid fa-lock fs-5 me-3"></i>
                            We have sent a code to your email address. Please check your inbox or spam folder as it may have been filtered there.
                            </p>
                            <div class="col-8 p-0">
                                <form action="forgot_pass.php?mode=enter_code" method="post">
                                    <!-- Code field -->
                                    <div class="form-outline row mb-3">
                                        <input type="text" name="code" id="code" class="form-control-lg border-0 rounded-3 border-dark-subtle" placeholder="Enter Code" required="required" autocomplete="off">
                                    </div>
                                    <!-- Submit button -->
                                    <div class="text-center row justify-content-end mb-5">
                                        <input type="submit" value="Submit Code" name="submit-code" class="submit-btn border-0 rounded-2 text-light py-1">
                                    </div>
                                    <br>
                                </form>
                            </div>
                        <?php
                            break;
                        case 'enter_password':
                            ?>  <p class="d-flex align-items-center px-5 mt-5 mb-4 p-0">
                            <i class="fas fa-solid fa-lock fs-5 me-3"></i>
                            Enter your new password
                            </p>
                            <div class="col-8 p-0">
                                <form action="forgot_pass.php?mode=enter_password" method="post">
                                    <!-- Password field -->
                                    <div class="form-outline row mb-3">
                                        <input type="password" name="password" id="password" class="form-control-md border-0 rounded-1" placeholder="Password" autocomplete="off" required="required">
                                    </div>
                                    <!-- Password field -->
                                    <div class="form-outline row mb-3">
                                        <input type="password" name="rpassword" id="rpassword" class="form-control-md border-0 rounded-1" placeholder="Repeat Password" autocomplete="off" required="required">
                                    </div>
                                    <!-- Submit button -->
                                    <div class="text-center row justify-content-end mb-5">
                                        <input type="submit" value="Confirm" name="confirm" class="submit-btn border-0 rounded-2 text-light py-1">
                                    </div>
                                    <br>
                                </form>
                                
                            </div>
                        <?php
                            break;
                        default:
                            break;
                    }
                ?>
                
            </div> 
        </div>
    </div>


    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>