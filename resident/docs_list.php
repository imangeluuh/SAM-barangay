
<?php 
    if(!session_id()){
        session_start(); 
    } 

    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../index.php");
        exit;
    }

    require_once "../language/" . $_SESSION['lang'] . ".php";
    
    if(isset($_POST['submit-brgy-id'])) {
        $birthplace = $_POST['birthplace'];
        $height = !empty($_POST['height']) ? $_POST['height'] : NULL;
        $weight = !empty($_POST['weight']) ? $_POST['weight'] : NULL;;
        $status = $_POST['status'];
        $religion = $_POST['religion'];
        $contact_name = $_POST['contact-name'];
        $contact_no = $_POST['contact-no'];
        $contact_address = $_POST['contact-address']; 
        $stmt = $conn->prepare("CALL SP_ADD_BRGY_ID(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('sssddsssi', $birthplace, $status, $religion, $height, $weight, $contact_name, $contact_address, $contact_no, $_SESSION['userData']['resident_id']);
        // Execute the prepared statement
        $stmt->execute();   

        if ($stmt) {
            echo "<script>alert('Thank you for submitting your request. Your request has been successfully received and is being processed.'); window.location.href = 'res_services.php';</script>";
            exit();
        }
    }

    if(isset($_POST['submit-coi'])) {
        $background_info = $_POST['background-info'];
        $purpose = $_POST['purpose'];
        $stmt = $conn->prepare("CALL SP_ADD_COI(?, ?, ?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('ssi', $background_info, $purpose, $_SESSION['userData']['resident_id']);
        // Execute the prepared statement
        $stmt->execute();   

        if ($stmt) {
            echo "<script>alert('Thank you for submitting your request. Your request has been successfully received and is being processed.'); window.location.href = 'res_services.php';</script>";
            exit();
        }
    }
?>

<a href="javascript:history.back()" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
    <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
</a><br>

<?php
        if(isset($_GET['barangay-id'])) { ?>
        <span class="fs-4 ms-4">Barangay ID</span>
        <form class="row g-3 mx-4 mt-2" method="post">
            <div class="col-md-6">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" disabled
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
            </div>
            <div class="col-md-3">
                <label for="Birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" disabled
                    value="<?php echo $_SESSION['userData']['birthdate'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Birthplace" class="form-label">Place of Birth</label>
                <input type="text" class="form-control" name="birthplace" id="birthplace" required>
            </div>
            <div class="col-12">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" disabled value="<?php echo $_SESSION['userData']['address'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Height" class="form-label">Height</label>
                <input type="text" class="form-control" name="height" id="height">
            </div>
            <div class="col-md-3">
                <label for="Weight" class="form-label">Weight</label>
                <input type="text" class="form-control" name="weight" id="weight">
            </div>
            <div class="col-md-3">
                <label for="Status" class="form-label">Status</label>
                <input type="text" class="form-control" name="status" id="status">
            </div>
            <div class="col-md-3">
                <label for="Religion" class="form-label">Religion</label>
                <input type="text" class="form-control" name="religion" id="religion">
            </div>
            <div class="col-12 mt-4">
                <span class="text-danger fw-semibold">In case of emergency, please notify:</span>
            </div>
            <div class="col-md-6">
                <label for="emergency-contact" class="form-label">Name</label>
                <input type="text" class="form-control" name="contact-name" id="contact-name">
            </div>
            <div class="col-md-6">
                <label for="contact-telephone" class="form-label">Telephone</label>
                <input type="text" class="form-control" name="contact-no" id="contact-no">
            </div>
            <div class="col-12">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" name="contact-address" id="contact-address">
            </div>
            <div class="col-12">
                <button type="submit" name="submit-brgy-id" class="btn btn-primary">Submit</button>
            </div>
        </form>
    <?php } else if(isset($_GET['certificate-of-indigency'])) { ?>
        <span class="fs-4 ms-4">Certificate of Indigency</span>
        <form class="row g-3 mx-4 mt-2" method="post">
            <div class="col-md-6">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" disabled
                    value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                echo $_SESSION['userData']['res_lastname']?>">
            </div>
            <?php
                // create a DateTime object from the birthdate string
                $birthday = new DateTime($_SESSION['userData']['birthdate']);

                // get the current date
                $today = new DateTime(date('m.d.y'));

                // calculate the difference between the birthdate and the current date
                $diff = $today->diff($birthday);

                // get the age in years
                $age = $diff->y;
            ?>
            <div class="col-md-2">
                <label for="Age" class="form-label">Age</label>
                <input type="text" class="form-control" id="age" disabled
                    value="<?php echo $age ?>">
            </div>
            <div class="col-12">
                <label for="background-info" class="form-label">Background Info</label><br>
                <textarea name="background-info" id="background-info" cols="100" rows="5" required="required"></textarea>
            </div>
            <div class="col-12">
                <label for="purpose" class="form-label">Purpose</label><br>
                <textarea name="purpose" id="purpose" cols="100" rows="2" required="required"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" name="submit-coi" class="btn btn-primary">Submit</button>
            </div>
        </form>

    
    <?php } else { ?>
        <div class="list-group list-group-flush fs-5 w-50">
            <a href="res_doc_req.php?barangay-id" class="d-flex justify-content-between list-group-item list-group-item-action">
                Barangay ID
                <i class="fa-solid fa-angle-right"></i>
            </a>
            <a href="res_doc_req.php?certificate-of-indigency" class="d-flex justify-content-between list-group-item list-group-item-action">
                Certificate of Indigency
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
    <?php }
?>
