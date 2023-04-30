
<?php 
    if(!session_id()){
        session_start(); 
    } 

    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../index.php");
        exit;
    }

    require_once "../language/" . $_SESSION['lang'] . ".php";
    
?>

<a href="javascript:history.back()" class="w-25 ms-4 d-flex align-items-center text-decoration-none text-secondary">
            <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
</a><br>

<?php
        if(isset($_GET['barangay-id'])) { ?>
        <span class="fs-4 ms-4">Barangay ID</span>
        <form class="row g-3 mx-4 mt-2">
            <div class="col-md-6">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" disabled
                    value="<?php echo $_SESSION['userData']['res_firstname'] . ' ' . $_SESSION['userData']['res_middlename'][0] . '. ' . $_SESSION['userData']['res_lastname']?>">
            </div>
            <div class="col-md-3">
                <label for="Birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" disabled
                    value="<?php echo $_SESSION['userData']['birthdate'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Birthplace" class="form-label">Place of Birth</label>
                <input type="text" class="form-control" id="birthplace" required>
            </div>
            <div class="col-12">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" disabled value="<?php echo $_SESSION['userData']['address'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Height" class="form-label">Height</label>
                <input type="text" class="form-control" id="height">
            </div>
            <div class="col-md-3">
                <label for="Weight" class="form-label">Weight</label>
                <input type="text" class="form-control" id="weight">
            </div>
            <div class="col-md-3">
                <label for="Status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status">
            </div>
            <div class="col-md-3">
                <label for="Religion" class="form-label">Religion</label>
                <input type="text" class="form-control" id="religion">
            </div>
            <div class="col-12 mt-4">
                <span class="text-danger fw-semibold">In case of emergency, please notify:</span>
            </div>
            <div class="col-md-6">
                <label for="emergency-contact" class="form-label">Name</label>
                <input type="text" class="form-control" id="contact-name">
            </div>
            <div class="col-md-6">
                <label for="contact-telephone" class="form-label">Telephone</label>
                <input type="text" class="form-control" id="contact-name">
            </div>
            <div class="col-12">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" id="contact-address">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    <?php } else if(isset($_GET['certificate-of-indigency'])) { ?>
        <form class="row g-3 mx-4 mt-2">
            <div class="col-md-6">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" disabled
                    value="<?php echo $_SESSION['userData']['res_firstname'] . ' ' . $_SESSION['userData']['res_middlename'][0] . '. ' . $_SESSION['userData']['res_lastname']?>">
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
                <textarea name="background-info" id="background-info" cols="100" rows="5"></textarea>
            </div>
            <div class="col-12">
                <label for="purpose" class="form-label">Purpose</label><br>
                <textarea name="purpose" id="purpose" cols="100" rows="2"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
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
