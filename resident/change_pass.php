<?php
    // Start session 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 

    // Include the database configuration file
    include('../dbconfig.php');
    require_once "../language/" . $_SESSION['lang'] . ".php";

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
                echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.different");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
            } else if($npassword !== $rpassword){
                echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.new-password");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
            } else {
                // Call the stored procedure to retrieve user login information from the database
                $stmt = $conn->prepare("CALL SP_UPDATE_PASS(?, ?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('ss', $email, $hash);
                // Execute the prepared statement
                $stmt->execute();
                $_SESSION['userData']['password'] = $npassword;
                echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.password-saved");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
            }
        } else {
            echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.inc-password");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
        }
    }

    
    ?>
    <!-- Toast notifications -->
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x mt-2">
        <div class="toast different text-bg-warning align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="material-symbols:warning" class="fs-4 ms-2 me-3"></iconify-icon>
                <?= $lang['notifMessages']['same_pass'] ?>
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x mt-2">
        <div class="toast new-password text-bg-warning align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="material-symbols:warning" class="fs-4 ms-2 me-3"></iconify-icon>
                <?= $lang['notifMessages']['pass_not_match'] ?>
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed position-fixed top-0 start-50 translate-middle-x mt-2">
        <div class="toast inc-password text-bg-danger align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="material-symbols:error" class="fs-4 ms-2 me-3"></iconify-icon>
                <?= $lang['notifMessages']['incorrect_pass'] ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x mt-2">
        <div class="toast password-saved text-bg-success align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="mdi:success-bold" class="fs-4 mx-2"></iconify-icon>
                <?= $lang['change_success'] ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <h1 class="fw-bold change-label  mt-5"><?php echo $lang['change_pass']?></h1>
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
                            <input type="password" name="npassword" id="npassword" size="45" class="form-control border-1 rounded-3 border-dark-subtle" autocomplete="off"
                                pattern=.{8,} title="Password must contain 8 or more characters" required>
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
                            <input type="password" name="rpassword" id="rpassword" size="45" class="form-control border-1 rounded-3 border-dark-subtle" autocomplete="off"
                                pattern=.{8,} title="Password must contain 8 or more characters" required>
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

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>