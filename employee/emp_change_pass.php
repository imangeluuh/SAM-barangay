<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbisyong Aagapay sa Mamayan</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS link -->
    <link rel="stylesheet" href="css/emp_change_pass.css">
    <!-- AdminLTE CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTable CSS link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>

<?php
    // Start session 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 

    // Include the database configuration file
    include('../dbconfig.php');
    require_once "../language/" . $_SESSION['lang'] . ".php";

    include('navbar.php');
    include('sidebar.php');
    ?>

    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row p-0 ms-md-3 me-md-5 pe-md-5">
                    <div class="col-lg-12 mt-5">
                        <?php
                        // Check if the login form has been submitted
                        if(isset($_POST['change'])){
                            // Get the input data
                            $password = $_POST['password'];
                            $npassword = $_POST['npassword'];
                            $rpassword = $_POST['rpassword'];
                            $email = $_SESSION['userData']['email'];
                            $hash = password_hash($npassword, PASSWORD_BCRYPT);
                            
                            if(password_verify($password, $_SESSION['userData']['password'])){
                                if($password == $npassword){
                                    echo "<script>alert('New password must be different from current password.'); window.location.href = 'emp_change_pass.php';</script>";
                                } else if($npassword !== $rpassword){
                                    echo "<script>alert('New password does not match.'); window.location.href = 'emp_change_pass.php';</script>";
                                } else {
                                    // Call the stored procedure to retrieve user login information from the database
                                    $stmt = $conn->prepare("CALL SP_UPDATE_PASS(?, ?)");
                                    // bind the input parameters to the prepared statement
                                    $stmt->bind_param('ss', $email, $hash);
                                    // Execute the prepared statement
                                    $stmt->execute();
                                    echo "<script>alert('Your password has been changed successfully!'); window.location.href = 'emp_change_pass.php';</script>";
                                    exit();
                                }
                            } else {
                                echo "<script>alert('Incorrect password.'); window.location.href = 'emp_change_pass.php';</script>";
                                exit();
                            }
                        }
                        ?>
                        <h1 class="fw-bold change-label"><?php echo $lang['change_pass']?></h1>
                        <div class="m-0 p-0">
                            <p class="desc"><?php echo $lang['recommend_pass']?></p>
                        </div>
                        <form action="" method="post" class="pe-md-5 me-md-5 mt-5">
                            <!-- Current Password field -->
                            <div class="field-div row justify-content-md-end p-0 pe-md-5 me-md-5">
                                <div class="col-auto">
                                    <div class="row d-flex p-0">
                                        <div class="col-md-6 d-flex justify-content-md-end">
                                            <label class="p-0"><?php echo $lang['current_pass']?></label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-outline mb-3">
                                                <input type="password" name="password" id="password" size="45" class="form-control border-1 rounded-3 border-dark-subtle" autocomplete="off" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- New Password field -->
                                    <div class="row d-flex p-0">
                                        <div class="col-md-6 d-flex justify-content-md-end">
                                            <label class="p-0"><?php echo $lang['new_pass']?></label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-outline mb-3">
                                                <input type="password" name="npassword" id="npassword" size="45" class="form-control border-1 rounded-3 border-dark-subtle" autocomplete="off" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Retype New Password field -->
                                    <div class="row d-flex p-0">
                                        <div class="col-md-6 d-flex justify-content-md-end">
                                            <label class="p-0"><?php echo $lang['repeat_pass']?></label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-outline mb-3">
                                                <input type="password" name="rpassword" id="rpassword" size="45" class="form-control border-1 rounded-3 border-dark-subtle" autocomplete="off" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit button -->
                            <div class="field-div text-center d-flex justify-content-md-end pe-md-5 me-md-5 mt-2">
                                <input type="submit" value="<?php echo $lang['save_changes']?>" name="change" class="save-button border-0 rounded-3 fw-light text-light p-0 px-2 me-md-4">
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- AdminLTE JS link -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
