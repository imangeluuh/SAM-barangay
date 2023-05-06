    <?php
    // Start session 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 

        // Include the database configuration file
        include('../dbconfig.php');

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
                echo "<script>alert('New password must be different from current password.'); window.location.href = 'res_settings.php?change-password';</script>";
            } else if($npassword !== $rpassword){
                echo "<script>alert('New password does not match.'); window.location.href = 'res_settings.php?change-password';</script>";
            } else {
                // Call the stored procedure to retrieve user login information from the database
                $stmt = $conn->prepare("CALL SP_UPDATE_PASS(?, ?)");

                // bind the input parameters to the prepared statement
                $stmt->bind_param('ss', $email, $hash);

                // Execute the prepared statement
                $stmt->execute();
                echo "<script>alert('Your password has been changed successfully!'); window.location.href = 'res_settings.php?change-password';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href = 'res_settings.php?change-password';</script>";
            exit();
        }
    }

    
    ?>
    <h1 class="fw-bold change-label">Change Password</h1>
    <div class="m-0 p-0">
        <p class="desc" >We recommend to use a password you're not using in other platform.</p>
    </div>
    <form action="" method="post" class="pe-md-5 me-md-5 mt-5">
        <!-- Current Password field -->
        <div class="row justify-content-md-end p-0 pe-md-5 me-md-5">
            <div class="col-auto">
                <div class="row d-flex p-0">
                    <div class="col-md-6 d-flex justify-content-md-end">
                        <label class="p-0">Current Password</label>
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
                        <label class="p-0">New Password</label>
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
                        <label class="p-0">Re-type New Password</label>
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
        <div class="text-center d-flex justify-content-md-end pe-md-5 me-md-5 mt-2">
            <input type="submit" value="Save Changes" name="change" class="save-button border-0 rounded-3 fw-light text-light p-0 me-md-2">
        </div>
    </form>