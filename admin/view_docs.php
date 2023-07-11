<?php 
    ob_start();
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: ../index.php");
        exit;
    }
?>
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
    <link rel="stylesheet" href="css/admin_style.css">
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
    <!-- JQuery UI  -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed hold-transition overflow-x-hidden">
    <div class="wrapper">
        <?php
            include('navbar.php');
            include('sidebar.php');
            include('../dbconfig.php');

            if(isset($_POST['view'])){
                // store the selected document data in session
                $docInfo = array('request_id' => $_POST['request_id']
                                            , 'document_type' => $_POST['document_type']
                                            , 'date_requested' => $_POST['date_requested']
                                            , 'date_completed' =>  $_POST['date_completed'] == NULL ? 'N/A' : $_POST['date_completed']
                                            , 'status' => $_POST['status']
                                            , 'doc_id' => $_POST['doc_id']
                                            , 'employee_name' => $_POST['employee_name']
                                            , 'resident_id' => $_POST['resident_id']);

                // Store the user data array in the $_SESSION variable for future use.
                $_SESSION['docInfo'] = $docInfo;
            }
        ?>
        <div class="content-wrapper" style="background-color: #ffffff!important">
            <div class="content">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-12 mx-5 mt-4">
                            <a href="./doc_records.php" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
                                <i class="fa-solid fa-angle-left me-3"></i><?php echo "Go Back"; ?>
                            </a><br>
                            <?php
                            if($_SESSION['docInfo']['document_type'] == 'Barangay ID') { 
                                $doc_id = $_SESSION['docInfo']['doc_id'];
                                $stmt = $conn->prepare("CALL SP_GET_BRGY_ID(?)");
                                // bind the input parameters to the prepared statement
                                $stmt->bind_param('i', $doc_id);
                                // Execute the prepared statement
                                $stmt->execute();
                                // retrieve the result set from the executed statement
                                $result = $stmt->get_result();  
                                // fetch the row from the result set
                                $row = $result->fetch_assoc();
                                $_SESSION['docInfo']['expiry_date'] = !empty($row['expiry_date']) ? $row['expiry_date']: "N/A";
                                $_SESSION['brgy-id'] = array('id' => $row['id_no']
                                                        , 'lastName' => $row['last_name']
                                                        , 'firstName' => $row['first_name']
                                                        , 'middleInitial' => !empty($row['middle_initial']) ? $row['middle_initial'] : NULL 
                                                        , 'address' => $row['res_address']
                                                        , 'birthdate' => $row['res_birthdate']
                                                        , 'birthplace' => $row['res_birthplace']
                                                        , 'precinctNo' => !empty($row['precinct_no']) ? $row['precinct_no'] : NULL
                                                        , 'contactName' => $row['contact_name']
                                                        , 'contactAddress' => $row['contact_address']
                                                        , 'contactNo' => $row['contact_no']
                                                        , 'dateIssued' => $row['date_issued']
                                                        , 'expiryDate' => $row['expiry_date']);
                            ?>
                                <div class="row d-flex justify-content-between">
                                    <span class="fs-4 ms-4" style="width: fit-content">Barangay ID</span>
                                </div>
                                <div class="row g-3 mx-4 mt-2">
                                    <?php displayDocInfo(); ?>
                                    <div class="col-md-4">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" disabled required
                                            value="<?php echo $row['first_name'] . " ";
                                                if (!empty($row['middle_initial'])) { echo $row['middle_initial'] . '. ';}
                                                echo $row['last_name']?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Age" class="form-label">Age</label>
                                        <input type="text" class="form-control" disabled 
                                            value="<?php echo $row['res_age']  ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Birthdate" class="form-label">Birthdate</label>
                                        <input type="date" class="form-control" id="birthdate" disabled required
                                            value="<?php echo $row['res_birthdate'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Birthplace" class="form-label">Place of Birth</label>
                                        <input type="text" class="form-control editable" id="birthplace" name="birthplace" disabled required="required"
                                            value="<?php echo $row['res_birthplace']?>">
                                    </div>
                                    <div class="col-md-9">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" disabled required value="<?php echo $row['res_address'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="precinct-no" class="form-label">Precinct No.</label>
                                        <input type="text" name="precinct-no" class="form-control editable" disabled value="<?php echo $row['precinct_no']?>">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <span class="text-danger fw-semibold">In case of emergency, please notify:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="emergency-contact" class="form-label">Name</label>
                                        <input type="text" class="form-control editable" id="contact-name" name="contact-name" required="required" disabled value="<?php echo $row['contact_name']?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="relationship" class="form-label">Relationship</label>
                                        <input type="text" class="form-control editable" name="relationship" id="relationship" value="<?php echo $row['relationship']; ?>" disabled required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="contact-telephone" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control editable" id="contact-no" name="contact-no" disabled required="required" value="<?php echo $row['contact_no']?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control editable" id="contact-address" name="contact-address" disabled required="required"  value="<?php echo $row['contact_address']?>">
                                    </div>
                            <?php } else if($_SESSION['docInfo']['document_type']  == 'Certificate of Indigency') { 
                                $doc_id = $_SESSION['docInfo']['doc_id'];
                                $stmt = $conn->prepare("CALL SP_GET_COI(?)");
                                // bind the input parameters to the prepared statement
                                $stmt->bind_param('i', $doc_id);
                                // Execute the prepared statement
                                $stmt->execute();
                                // retrieve the result set from the executed statement
                                $result = $stmt->get_result();  
                                // fetch the row from the result set
                                $row = $result->fetch_assoc();
                                $_SESSION['docInfo']['expiry_date'] = !empty($row['expiry_date']) ? $row['expiry_date'] : "N/A";
                                $_SESSION['certificate'] = array('id' => $row['indigency_id']
                                                                , 'name' => $row['res_name']
                                                                , 'age' => $row['res_age']);
                            ?>
                                <div class="row d-flex justify-content-between">
                                    <span class="fs-4 ms-4" style="width: fit-content">Certificate of Indigency</span>
                                </div>
                                <div class="row g-3 mx-4 mt-2">
                                    <?php displayDocInfo(); ?>
                                    <div class="col-md-6">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" disabled
                                            value="<?php echo $row['res_name']?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Age" class="form-label">Age</label>
                                        <input type="text" class="form-control" id="age" disabled
                                            value="<?php echo $row['res_age'] ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" disabled required value="<?php echo $row['res_address'] ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="purpose" class="form-label">Purpose</label><br>
                                        <textarea class="editable" name="purpose" id="purpose" cols="100" rows="2" disabled required="required"><?php
                                            echo $row['purpose']
                                        ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image" class="form-label fw-normal fst-italic">Attachment</label><br>
                                        <div class="img-box">
                                        <?php if ($row['requirements'] != NULL): 
                                            echo '<img src="data:image/jpeg;base64,'.base64_encode($row['requirements']).'" class="img-thumbnail"/>';
                                        endif; ?>
                                        </div>
                                    </div>
                            <?php } else if($_SESSION['docInfo']['document_type']  == 'Barangay Clearance') { 
                                $doc_id = $_SESSION['docInfo']['doc_id'];
                                $stmt = $conn->prepare("CALL SP_GET_CLEARANCE(?)");
                                // bind the input parameters to the prepared statement
                                $stmt->bind_param('i', $doc_id);
                                // Execute the prepared statement
                                $stmt->execute();
                                // retrieve the result set from the executed statement
                                $result = $stmt->get_result();  
                                // fetch the row from the result set
                                $row = $result->fetch_assoc();
                                $_SESSION['docInfo']['expiry_date'] = !empty($row['expiry_date']) ? $row['expiry_date']: "N/A";
                                $_SESSION['clearance'] = array('id' => $row['clearance_id']
                                                            , 'name' => $row['res_name']
                                                            , 'res_age' => $row['res_age']
                                                            , 'address' => $row['res_address']
                                                            , 'civil_status' => $row['civil_status']
                                                            , 'nationality' => $row['nationality']
                                                            , 'purpose' => $row['purpose']);
                            ?>
                                <div class="row d-flex justify-content-between">
                                    <span class="fs-4 ms-4" style="width: fit-content">Barangay Clearance</span>
                                </div>
                                <div class="row g-3 mx-4 mt-2">
                                    <?php displayDocInfo(); ?>
                                    <div class="col-md-6">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" disabled
                                            value="<?php echo $row['res_name']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Age" class="form-label">Age</label>
                                        <input type="text" class="form-control" id="age" disabled
                                            value="<?php echo $row['res_age'] ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" disabled value="<?php echo $row['res_address'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="civil-status" class="form-label">Civil Status</label>
                                        <input type="text" name="civil-status" class="form-control" disabled required value="<?php echo $row['civil_status']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nationality" class="form-label">Nationality</label>
                                        <input type="text" name="nationality" class="form-control" disabled required value="<?php echo $row['nationality']?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="purpose" class="form-label">Purpose</label><br>
                                        <textarea name="purpose" id="purpose" cols="100" rows="2" disabled><?php
                                            echo $row['purpose']
                                        ?></textarea>
                                    </div>
                                </div>
                            <?php } else if($_SESSION['docInfo']['document_type']  == 'Business Permit') { 
                                $doc_id = $_SESSION['docInfo']['doc_id'];
                                $stmt = $conn->prepare("CALL SP_GET_PERMIT(?)");
                                // bind the input parameters to the prepared statement
                                $stmt->bind_param('i', $doc_id);
                                // Execute the prepared statement
                                $stmt->execute();
                                // retrieve the result set from the executed statement
                                $result = $stmt->get_result();  
                                // fetch the row from the result set
                                $row = $result->fetch_assoc();
                                $_SESSION['docInfo']['expiry_date'] = !empty($row['expiry_date']) ? $row['expiry_date']: "N/A";
                                $_SESSION['permit'] = array('id' => $row['permit_id']
                                                            , 'name' => $row['business_owner']
                                                            , 'business-name' => $row['business_name']
                                                            , 'address' => $row['business_address']
                                                            , 'expiry_date' => $row['expiry_date']);
                            ?>
                                <div class="row d-flex justify-content-between">
                                    <span class="fs-4 ms-4" style="width: fit-content">Business Permit</span>
                                </div>
                                <div class="row g-3 mx-4 mt-2">
                                    <?php displayDocInfo(); ?>
                                    <div class="col-12">
                                        <label for="status">For:</label>
                                        <span><?php echo $row['status']?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Name" class="form-label">Business Owner</label>
                                        <input type="text" class="form-control" disabled
                                            value="<?php echo $row['business_owner']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="business-name" class="form-label">Business Name</label>
                                        <input type="text" name="business-name" class="form-control" disabled
                                            value="<?php echo $row['business_name']?>" >
                                    </div>
                                    <div class="col-md-12">
                                        <label for="business-address" class="form-label">Business Adress</label>
                                        <input type="text" name="business-address" class="form-control" disabled
                                            value="<?php echo $row['business_address']?>">
                                    </div>
                                </div>    
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
function displayDocInfo() { ?>
<div class="col-md-3">
    <label for="date-requested" class="form-label">Date Requested</label><br>
    <span><?php echo $_SESSION['docInfo']['date_requested'] ?></span>
</div>
<div class="col-md-3">
    <label for="date-completed" class="form-label">Date Completed</label><br>
    <span><?php echo $_SESSION['docInfo']['date_completed'] ?></span>
</div>
<div class="col-md-3">
    <label for="date-completed" class="form-label">Expiry Date</label><br>
    <span><?php echo $_SESSION{'docInfo'}['expiry_date'] ?></span>
</div>
<div class="col-md-3">
    <label for="date-completed" class="form-label">Status</label><br>
    <span><?php echo $_SESSION['docInfo']['status'] ?></span>
</div>
<?php } ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- AdminLTE JS link -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>