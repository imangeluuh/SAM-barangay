<?php 
    if(!session_id()){
        session_start(); 
    } 

    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../index.php");
        exit;
    }
    require_once "../language/" . $_SESSION['lang'] . ".php";

    if(isset($_SESSION['error_message'])) {
        if($_SESSION['error_message'] == 'invalid format') {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Get the toast element
                    var toast = document.querySelector(".toast.invalid");
                    
                    // Show the toast
                    toast.classList.add("show");
                    
                    // Hide the toast after 5 seconds
                    setTimeout(function() {
                        toast.classList.remove("show");
                    }, 5000);
                });
            </script>';
        }else if($_SESSION['error_message'] == 'large file') {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Get the toast element
                    var toast = document.querySelector(".toast.large");
                    
                    // Show the toast
                    toast.classList.add("show");
                    
                    // Hide the toast after 5 seconds
                    setTimeout(function() {
                        toast.classList.remove("show");
                    }, 5000);
                });
            </script>';
        }
        unset($_SESSION['error_message']); // Remove the session variable after displaying the message
    }
?>

<!-- Toast notifications -->
<div class="toast-container top-0 end-0 me-4">
    <div class="toast invalid text-bg-warning align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex align-items-center">
            <div class="toast-body d-flex align-items-center">
            <iconify-icon icon="material-symbols:warning" class="fs-4 ms-2 me-3"></iconify-icon>
            Sorry, only JPG, JPEG, & PNG files are allowed to upload.
            </div>
            <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <div class="toast large text-bg-warning align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex align-items-center">
            <div class="toast-body d-flex align-items-center">
            <iconify-icon icon="material-symbols:warning" class="fs-4 ms-2 me-3"></iconify-icon>
            File is too large.
            </div>
            <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<a href="javascript:history.back()" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
    <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
</a><br>

<?php
        if(isset($_GET['barangay-id'])) { ?>
        <span class="fs-4 ms-4">Barangay ID</span>
        <form action="submit_request.php" method="post" enctype="multipart/form-data" class="row g-3 mx-4 mt-2" >
            <div class="col-md-4">
                <label for="Name" class="form-label">Name</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="first-name" id="first-name" 
                    value="<?php echo $_SESSION['userData']['res_firstname'] ?>">
                <input type="hidden" class="form-control" name="middle-initial" id="middle-initial" 
                    value="<?php echo !empty($_SESSION['userData']['res_middlename']) ? $_SESSION['userData']['res_middlename'][0] : NULL; ?>">
                <input type="hidden" class="form-control" name="last-name" id="last-name" 
                    value="<?php echo $_SESSION['userData']['res_lastname']?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control" disabled
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
            </div>
            <?php getAge(); ?>
            <div class="col-md-2">
                <label for="Age" class="form-label">Age</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="res-age" id="age" 
                    value="<?php echo $GLOBALS['age']  ?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control" disabled 
                    value="<?php echo $GLOBALS['age']  ?>">
            </div>
            <div class="col-md-3">
                <label for="Birthdate" class="form-label">Birthdate</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="birthdate" id="birthdate" 
                    value="<?php echo $_SESSION['userData']['birthdate'] ?>">
                <!-- Visible input field for display purposes -->
                <input type="date" class="form-control" name="birthdate" id="birthdate" disabled 
                    value="<?php echo $_SESSION['userData']['birthdate'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Birthplace" class="form-label">Place of Birth</label>
                <input type="text" class="form-control" name="birthplace" id="birthplace" required>
            </div>
            <div class="col-md-9">
                <label for="Address" class="form-label">Address</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="address" id="address" value="<?php echo $_SESSION['userData']['address'] ?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control"disabled value="<?php echo $_SESSION['userData']['address'] ?>">
            </div>
            <div class="col-md-3">
            <label for="precinct-no" class="form-label">Precinct No.</label>
                <input type="text" name="precinct-no" class="form-control">
            </div>
            <div class="col-12 mt-4">
                <span class="text-danger fw-semibold">In case of emergency, please notify:</span>
            </div>
            <div class="col-md-4">
                <label for="emergency-contact" class="form-label">Name</label>
                <input type="text" class="form-control" name="contact-name" id="contact-name" required>
            </div>
            <div class="col-md-4">
                <label for="relationship" class="form-label">Relationship</label>
                <input type="text" class="form-control" name="relationship" id="relationship" required>
            </div>
            <div class="col-md-4">
                <label for="contact-telephone" class="form-label">Contact Number</label>
                <input type="text" class="form-control" name="contact-no" id="contact-no" pattern="^09\d{9}$" title="Enter a Phone Number (Format: 09XXXXXXXXX)" required>
            </div>
            <div class="col-12">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" name="contact-address" id="contact-address" required>
            </div>
            <input type="hidden" class="form-control" name="document-type" id="document-type" value="barangay id">
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    <?php } else if(isset($_GET['certificate-of-indigency'])) { ?>
        <span class="fs-4 ms-4">Certificate of Indigency</span>
        <form action="submit_request.php" class="row g-3 mx-4 mt-2" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <label for="Name" class="form-label">Name</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="res-name" id="name" 
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control"disabled 
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
            </div>
            <?php getAge(); ?>
            <div class="col-md-3">
                <label for="Age" class="form-label">Age</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="res-age" id="age" 
                    value="<?php echo $GLOBALS['age']  ?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control" disabled 
                    value="<?php echo $GLOBALS['age']  ?>">
            </div>
            <div class="col-12">
                <label for="Address" class="form-label">Address</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="address" id="address" value="<?php echo $_SESSION['userData']['address'] ?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control"disabled value="<?php echo $_SESSION['userData']['address'] ?>">
            </div>
            <div class="col-12">
                <label for="purpose" class="form-label">Purpose</label><br>
                <textarea name="purpose" id="purpose" cols="100" rows="2" required="required"></textarea>
            </div>
            <div class="col-md-6">
                <label for="image" class="form-label fw-normal fst-italic">*For burial purpose, please upload death certificate</label><br>
                <div class="d-flex">
                    <input type='file' name="image" id="image" class="form-control rounded-end-0" onchange="pressed()">
                    <label id="fileLabel" class="form-control fw-normal rounded-start-0">No file chosen</label>
                </div>
            </div>
            <input type="hidden" class="form-control" name="document-type" id="document-type" value="certificate of indigency">
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    <?php } else if(isset($_GET['barangay-clearance'])) { ?>
        <span class="fs-4 ms-4">Barangay Clearance</span>
        <form action="submit_request.php" class="row g-3 mx-4 mt-2" method="post">
            <div class="col-md-9">
                <label for="Name" class="form-label">Name</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="res-name" id="name" 
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control"disabled 
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
            </div>
            <?php getAge(); ?>
            <div class="col-md-3">
                <label for="Age" class="form-label">Age</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="res-age" id="age" 
                    value="<?php echo $GLOBALS['age']  ?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control" disabled 
                    value="<?php echo $GLOBALS['age']  ?>">
            </div>
            <div class="col-12">
                <label for="Address" class="form-label">Address</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="address" id="address" value="<?php echo $_SESSION['userData']['address'] ?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control"disabled value="<?php echo $_SESSION['userData']['address'] ?>">
            </div>
            <div class="col-md-6">
                <label for="civil-status" class="form-label">Civil Status</label>
                <input type="text" name="civil-status" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="nationality" class="form-label">Nationality</label>
                <input type="text" name="nationality" class="form-control">
            </div>
            <div class="col-12">
                <label for="purpose" class="form-label">Purpose</label><br>
                <textarea name="purpose" id="purpose" cols="100" rows="2" required="required"></textarea>
            </div>
            <input type="hidden" class="form-control" name="document-type" id="document-type" value="barangay clearance">
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    <?php } else if(isset($_GET['business-permit'])) { ?>
        <span class="fs-4 ms-4">Business Permit</span>
        <form action="submit_request.php" class="row g-3 mx-4 mt-2" method="post">
            <div class="col-md-2">
                <label for="status">Please Select:</label>
            </div>
            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status" value="Renewal">
                    <label class="form-check-label" for="renewal">Renewal</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status" value="New">
                    <label class="form-check-label" for="new">New</label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="Name" class="form-label">Business Owner</label>
                <!-- Hidden input field to store the name value -->
                <input type="hidden" class="form-control" name="res-name" id="res-name" 
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
                <!-- Visible input field for display purposes -->
                <input type="text" class="form-control" disabled
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
            </div>
            <div class="col-md-6">
                <label for="business-name" class="form-label">Business Name</label>
                <input type="text" name="business-name" required class="form-control">
            </div>
            <div class="col-md-12">
                <label for="business-address" class="form-label">Business Address</label>
                <input type="text" name="business-address" required class="form-control">
            </div>
            <input type="hidden" class="form-control" name="document-type" id="document-type" value="business permit">
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    <?php } ?>
<?php $age = NULL;
function getAge() {
    // create a DateTime object from the birthdate string
    $birthday = new DateTime($_SESSION['userData']['birthdate']);
    // get the current date
    $today = new DateTime(date('m.d.y'));
    // calculate the difference between the birthdate and the current date
    $diff = $today->diff($birthday);
    // get the age in years
    $GLOBALS['age'] = $diff->y;
} ?>
<script>
    window.pressed = function(){
        var a = document.getElementById('image');
        if(a.value == "")
        {
            fileLabel.innerHTML = "No file chosen";
        }
        else
        {
            var theSplit = a.value.split('\\');
            fileLabel.innerHTML = theSplit[theSplit.length-1];
        }
    };
</script>
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
