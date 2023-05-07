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
        $fname = $_POST['f-name'];
        $mname = !empty($_POST['md-name']) ? $_POST['md-name'] : NULL;;
        $lname = $_POST['l-name'];
        $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $address = $_POST['address'];
        $resident_id = $_SESSION['userData']['resident_id'];
        
        // create a DateTime object from the birthdate string
        $birthday = new DateTime($birthdate);
        // get the current date
        $today = new DateTime(date('m.d.y'));
        // calculate the difference between the birthdate and the current date
        $diff = $today->diff($birthday);
        // get the age in years
        $age = $diff->y;

        if ($age < 18){
            echo "<script>alert('You must be at least 18 years old to create an account.');</script>";
        } else{
            // Call the stored procedure
            $stmt = $conn->prepare("CALL SP_UPDATE_RES_INFO(?, ?, ?, ?, ?, ?, ?)");
            // bind the input parameters to the prepared statement
            $stmt->bind_param('ssssssi', $fname, $mname, $lname, $birthdate, $address, $email, $resident_id);
            
            try {
                // Execute the prepared statement
                $stmt->execute();
                // Check for errors
                if ($stmt->errno) {
                    echo "<script>alert('An account with that email already exists. Please try another one.'); window.location.href = 'res_settings.php?update-credentials';</script>";
                    die('Failed to call stored procedure: ' . $stmt->error);
                } else {
                    $_SESSION['userData']['email'] = $email;
                    $_SESSION['userData']['res_firstname'] = $fname; 
                    $_SESSION['userData']['res_middlename'] = $mname; 
                    $_SESSION['userData']['res_lastname'] = $lname; 
                    $_SESSION['userData']['birthdate'] = $birthdate; 
                    $_SESSION['userData']['address'] = $address; 

                    echo "<script>alert('Your profile information has been updated successfully!'); window.location.href = 'res_settings.php?update-credentials';</script>";
                }
                exit();
            }
            catch (mysqli_sql_exception $e) {
                echo "<script>alert('An account with that email already exists. Please try another one.'); window.location.href = 'res_settings.php?update-credentials';</script>";
                exit();
            }
        }
    }
    
    ?>
    <h1 class="fw-bold change-label"><?php echo $lang['edit_profile'] ?></h1>
    <div class="m-0 p-0">
        <p class="desc"><?php echo $lang['save_instruction'] ?></p>
    </div>
    <form action="" method="post" class="pt-5 pe-md-5 me-md-5">
        <!-- First Name field -->
        <div class="field-div row justify-content-md-end pe-md-5 me-md-5">
            <div class="col-auto">
                <!-- First Name field -->
                <div class="row d-flex p-0">
                    <div class="col-md-4 d-flex justify-content-md-end">
                        <label class="p-0"><?php echo $lang['first_name'] ?></label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-outline mb-3">
                            <input type="text" name="f-name" id="f-name" size="56" value="<?php echo $_SESSION['userData']['res_firstname']; ?>" class="form-control border-1 rounded-3" required="required">
                        </div>
                    </div>
                </div>
                <!-- Middle Name field -->
                <div class="row d-flex p-0">
                    <div class="col-md-4 d-flex justify-content-md-end">
                        <label class="p-0"><?php echo $lang['middle_name'] ?></label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-outline mb-3">
                            <input type="text" name="md-name" id="md-name" size="56" value="<?php echo $_SESSION['userData']['res_middlename'];?>" class="form-control border-1 rounded-3">
                        </div>
                    </div>
                </div>
                <!-- Last Name field -->
                <div class="row d-flex p-0">    
                    <div class="col-md-4 d-flex justify-content-md-end">
                        <label class="p-0"><?php echo $lang['last_name'] ?></label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-outline mb-3">
                            <input type="text" name="l-name" id="l-name" size="56" value="<?php echo $_SESSION['userData']['res_lastname'];?>" class="form-control border-1 rounded-3" required="required">
                        </div>
                    </div>
                </div>                    
                <!-- Email and Birthday field -->
                <div class="row d-flex p-0">    
                    <div class="col-md-4 d-flex justify-content-md-end">
                        <label class="p-0 text-end"><?php echo $lang['birthdate'] ?></label>
                    </div>
                    <div class="col-md-5">
                        <div class="form-outline mb-3">
                            <input type="date" name="birthdate" id="birthdate" value="<?php echo $_SESSION['userData']['birthdate'];?>" class="form-control border-1 rounded-3" placeholder="Last Name" required="required">
                        </div>
                    </div>
                </div>
                <div class="row d-flex p-0">    
                    <div class="col-md-4 d-flex justify-content-md-end">
                        <label class="p-0">Email</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-outline mb-3">
                            <input type="email" name="email" id="email" size="18" value="<?php echo $_SESSION['userData']['email'];?>" class="form-control border-1 rounded-3" required="required">
                        </div>
                    </div> 
                </div>
                <!-- Address field -->
                <div class="row d-flex p-0">
                    <div class="col-md-4 d-flex justify-content-md-end">
                        <label class="p-0"><?php echo $lang['address'] ?></label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-outline mb-3">
                            <input type="text" name="address" id="address" size="56" value="<?php echo $_SESSION['userData']['address'];?>" class="form-control border-1 rounded-3" required="required">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit button -->
        <div class="field-div text-center d-flex justify-content-md-end pe-md-5 me-md-5 mt-2">
            <input type="submit" value="Save Changes" name="change" class="save-button border-0 rounded-3 fw-light text-light p-0 px-2 me-md-4">
        </div>
    </form>