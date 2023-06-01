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
    <link rel="stylesheet" href="css/res_services.css">
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
            ob_start();
            // If a session is not already started, start a new session
            if(!session_id()){
                session_start(); 
            } 

            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                header("Location: ../index.php");
                exit;
            }

            require_once "../language/" . $_SESSION['lang'] . ".php";
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
                                            , 'schedule' => $_POST['schedule']);

                // Store the user data array in the $_SESSION variable for future use.
                $_SESSION['docInfo'] = $docInfo;
            }

            if(isset($_POST['save_id'])) { 
                // Fetch any remaining result sets
                while($conn->next_result()) {
                    $conn->store_result();
                }

                if(isset($_POST['datepicker']) && isset($_POST['time'])) {
                    $date = DateTime::createFromFormat('m/d/Y', $_POST['datepicker']);
                    $schedule = $date->format('Y-m-d') . " " . $_POST['time'];
                    
                    $stmt = $conn->prepare("CALL SP_UPDATE_REQUEST(?, ?)");
                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('is', $_SESSION['docInfo']['request_id'], $schedule);
                    // Execute the prepared statement
                    $stmt->execute();  
                } else {
                    $birthplace = $_POST['birthplace'];
                    $height = !empty($_POST['height']) ? $_POST['height'] : NULL;
                    $weight = !empty($_POST['weight']) ? $_POST['weight'] : NULL;;
                    $status = $_POST['status'];
                    $religion = $_POST['religion'];
                    $contact_name = $_POST['contact-name'];
                    $contact_no = $_POST['contact-no'];
                    $contact_address = $_POST['contact-address']; 
                    $stmt = $conn->prepare("CALL SP_UPDATE_BRGY_ID(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('isddsssss', $_SESSION['docInfo']['doc_id'], $birthplace, $height, $weight, $status, $religion, $contact_name, $contact_address, $contact_no);
                    // Execute the prepared statement
                    $stmt->execute();    
                }

                // Close the prepared statement and database connection
                $stmt->close();
                $conn->close();
                
                header("Location: view_docs.php");
                exit();
            }
        
            if(isset($_POST['save_coi'])) { 
                // Fetch any remaining result sets
                while($conn->next_result()) {
                    $conn->store_result();
                }

                if(isset($_POST['datepicker']) && isset($_POST['time'])) {
                    $date = DateTime::createFromFormat('m/d/Y', $_POST['datepicker']);
                    $schedule = $date->format('Y-m-d') . " " . $_POST['time'];
                    
                    $stmt = $conn->prepare("CALL SP_UPDATE_REQUEST(?, ?)");
                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('is', $_SESSION['docInfo']['request_id'], $schedule);
                    // Execute the prepared statement
                    $stmt->execute();  
                    $_SESSION['docInfo']['schedule'] = $schedule;
                } else {
                    $background_info = trim($_POST['background-info']);
                    $purpose = trim($_POST['purpose']);
            
                    $stmt = $conn->prepare("CALL SP_UPDATE_COI(?, ?, ?)");
                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('iss', $_SESSION['docInfo']['doc_id'], $background_info, $purpose);
                    // Execute the prepared statement
                    $stmt->execute();  
                }

                // Close the prepared statement and database connection
                $stmt->close();
                $conn->close();
                
                header("Location: view_docs.php");
                exit();
            }

            
            if(isset($_POST['save_clearance'])) { 
                // Fetch any remaining result sets
                while($conn->next_result()) {
                    $conn->store_result();
                }

                if(isset($_POST['datepicker']) && isset($_POST['time'])) {
                    $date = DateTime::createFromFormat('m/d/Y', $_POST['datepicker']);
                    $schedule = $date->format('Y-m-d') . " " . $_POST['time'];
                    
                    $stmt = $conn->prepare("CALL SP_UPDATE_REQUEST(?, ?)");
                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('is', $_SESSION['docInfo']['request_id'], $schedule);
                    // Execute the prepared statement
                    $stmt->execute();  
                    $_SESSION['docInfo']['schedule'] = $schedule;
                } else {
                    $background_info = trim($_POST['background-info']);
                    $purpose = $_POST['purpose'];
            
                    $stmt = $conn->prepare("CALL SP_UPDATE_CLEARANCE(?, ?)");
                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('is', $_SESSION['docInfo']['doc_id'], $purpose);
                    // Execute the prepared statement
                    $stmt->execute();  
                }

                // Close the prepared statement and database connection
                $stmt->close();
                $conn->close();
                
                header("Location: view_docs.php");
                exit();
            }

            if(isset($_POST['save_permit'])) { 
                // Fetch any remaining result sets
                while($conn->next_result()) {
                    $conn->store_result();
                }

                if(isset($_POST['datepicker']) && isset($_POST['time'])) {
                    $date = DateTime::createFromFormat('m/d/Y', $_POST['datepicker']);
                    $schedule = $date->format('Y-m-d') . " " . $_POST['time'];
                    
                    $stmt = $conn->prepare("CALL SP_UPDATE_REQUEST(?, ?)");
                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('is', $_SESSION['docInfo']['request_id'], $schedule);
                    // Execute the prepared statement
                    $stmt->execute();  
                    $_SESSION['docInfo']['schedule'] = $schedule;
                } else {
                    $businessName = $_POST['business-name']; 
            $businessLine = $_POST['business-line']; 
            $businessAddress = $_POST['business-address']; 
            
                    $stmt = $conn->prepare("CALL SP_UPDATE_PERMIT(?, ?, ?, ?)");
                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('isss', $_SESSION['docInfo']['doc_id'], $businessName, $businessLine, $businessAddress);
                    // Execute the prepared statement
                    $stmt->execute();  
                }

                // Close the prepared statement and database connection
                $stmt->close();
                $conn->close();
                
                header("Location: view_docs.php");
                exit();
            }

            // Get all the dates that have at least one booking
            $stmt = $conn->prepare("CALL SP_FULL_SLOT");
            $stmt->execute();
            
            if($stmt) {
                // Put the dates in an array to be used later
                $full_slots = array();
                $result = $stmt->get_result();  
                while ($row = $result->fetch_assoc()) {
                    $full_slots[] = $row['date'];
                }

                // Fetch any remaining result sets
                while($conn->next_result()) {
                    $conn->store_result();
                }
            }   

            
        ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-12 mx-5 mt-4">
                            <a href="res_services.php" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
                                <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
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
                            ?>
                                <span class="fs-4 ms-4">Barangay ID</span>
                                
                                <form class="row g-3 mx-4 mt-2" method="post" senctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to save these changes?')">
                                    <div class="col-md-4">
                                        <label for="date-requested" class="form-label">Date Requested</label><br>
                                        <span><?php echo $_SESSION['docInfo']['date_requested'] ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date-completed" class="form-label">Date Completed</label><br>
                                        <span><?php echo $_SESSION['docInfo']['date_completed'] ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date-completed" class="form-label">Status</label><br>
                                        <span><?php echo $_SESSION['docInfo']['status'] ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date-issued" class="form-label">Date Issued</label><br>
                                        <span><?php echo $row['date_issued'] == NULL ? 'N/A' : $row['date_issued'] ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="expiry-date" class="form-label">Expiry Date</label><br>
                                        <span><?php echo $row['expiry_date'] == NULL ? 'N/A' : $row['expiry_date'] ?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" disabled required
                                            value="<?php echo $row['res_name']?>">
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
                                    <div class="col-12">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" disabled required value="<?php echo $row['res_address'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Height" class="form-label">Height</label>
                                        <input type="text" class="form-control editable" id="height" name="height" disabled value="<?php echo $row['res_height']?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Weight" class="form-label">Weight</label>
                                        <input type="text" class="form-control editable" id="weight" name="weight" disabled value="<?php echo $row['res_weight']?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Status" class="form-label">Status</label>
                                        <input type="text" class="form-control editable" id="status" name="status" disabled required="required" value="<?php echo $row['res_status']?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Religion" class="form-label">Religion</label>
                                        <input type="text" class="form-control editable" id="religion" name="religion" disabled required value="<?php echo $row['res_religion']?>">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <span class="text-danger fw-semibold">In case of emergency, please notify:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="emergency-contact" class="form-label">Name</label>
                                        <input type="text" class="form-control editable" id="contact-name" name="contact-name" required="required" disabled value="<?php echo $row['contact_name']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact-telephone" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control editable" id="contact-no" name="contact-no" disabled required="required" value="<?php echo $row['contact_no']?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control editable" id="contact-address" name="contact-address" disabled required="required"  value="<?php echo $row['contact_address']?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="image" class="form-label">Valid ID</label><br>
                                        <div class="img-box">
                                        <?php  echo '<img src="data:image/jpeg;base64,'.base64_encode($row['valid_id']).'" class="img-thumbnail"/>';
                                        ?>
                                        </div>
                                    </div>
                                    <!-- // popup modal -->
                                    <div class="modal fade" id="enlargedModal" tabindex="-1" role="dialog" aria-labelledby="enlargedModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="" class="enlarged-image w-100" alt="Enlarged Image">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                        <div class="col-12 mt-4">
                                            <span class="fw-semibold">Appointment Information</span>
                                        </div>
                                        <!-- Datepicker -->
                                        <div class="col-md-6">
                                            <input type="text" class="form-control schedule" id="datepicker" name="datepicker" disabled required="required"
                                                value="<?php if(!empty($_SESSION['docInfo']['schedule'])) {echo $_SESSION['docInfo']['schedule'];}?>">
                                            <div class="row option mt-4 d-none">
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="08:00:00"><label class="ms-1 fw-semibold">8:00AM - 9:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="09:00:00"><label class="ms-1 fw-semibold">9:00AM - 10:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="10:00:00"><label class="ms-1 fw-semibold">10:00AM - 11:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="11:00:00"><label class="ms-1 fw-semibold">11:00AM - 12:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="13:00:00"><label class="ms-1 fw-semibold">1:00PM - 2:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="14:00:00"><label class="ms-1 fw-semibold">2:00PM - 3:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="15:00:00"><label class="ms-1 fw-semibold">3:00PM - 4:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="16:00:00"><label class="ms-1 fw-semibold">4:00PM - 5:00PM</label>
                                                </div>
                                            </div>
                                        </div>  
                                    <?php } else if ($_SESSION['docInfo']['status'] == 'Claimed') { ?>
                                        <div class="col-md-4 mt-4">
                                        <label for="schedule" class="form-label">Schedule</label><br>
                                            <span><?php echo $_SESSION['docInfo']['schedule']; ?></span>
                                        </div>
                                    <?php } ?> 
                                    <div class="col-12">
                                        <input type="submit" name="save_id" value="Save" class="btn btn-primary save-btn d-none">
                                    </div>
                                </form>
                                <?php if($_SESSION['docInfo']['status'] == 'Pending') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary edit-btn brgy-id mb-4">Edit</button>
                                    </div>  
                                <?php } else if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary appointment-btn mb-4">Set Appointment</button>
                                    </div>
                                <?php }  
                            } else if($_SESSION['docInfo']['document_type']  == 'Certificate of Indigency') { 
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
                            ?>
                                <span class="fs-4 ms-4">Certificate of Indigency</span>
                                <form class="row g-3 mx-4 mt-2" method="post" onSubmit="return confirm('Are you sure you want to save these changes?')">
                                <div class="col-md-4">
                                        <label for="date-requested" class="form-label">Date Requested</label><br>
                                        <span><?php echo $_SESSION['docInfo']['date_requested'] ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date-completed" class="form-label">Date Completed</label><br>
                                        <span><?php echo $_SESSION['docInfo']['date_completed'] ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date-completed" class="form-label">Status</label><br>
                                        <span><?php echo $_SESSION['docInfo']['status'] ?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" disabled
                                            value="<?php echo $row['res_name']?>">
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
                                    <?php if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                        <div class="col-12 mt-4">
                                            <span class="fw-semibold">Appointment Information</span>
                                        </div>
                                        <!-- Datepicker -->
                                        <div class="col-md-6">
                                            <input type="text" class="form-control schedule" id="datepicker" name="datepicker" disabled required="required"
                                                value="<?php if(!empty($_SESSION['docInfo']['schedule'])) {echo $_SESSION['docInfo']['schedule'];}?>" >
                                            <div class="row option mt-4 d-none">
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="08:00:00"><label class="ms-1 fw-semibold">8:00AM - 9:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="09:00:00"><label class="ms-1 fw-semibold">9:00AM - 10:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="10:00:00"><label class="ms-1 fw-semibold">10:00AM - 11:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="11:00:00"><label class="ms-1 fw-semibold">11:00AM - 12:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="13:00:00"><label class="ms-1 fw-semibold">1:00PM - 2:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="14:00:00"><label class="ms-1 fw-semibold">2:00PM - 3:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="15:00:00"><label class="ms-1 fw-semibold">3:00PM - 4:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="16:00:00"><label class="ms-1 fw-semibold">4:00PM - 5:00PM</label>
                                                </div>
                                            </div>
                                        </div>  
                                    <?php } else if ($_SESSION['docInfo']['status'] == 'Claimed') { ?>
                                        <div class="col-md-4 mt-4">
                                            <label for="schedule" class="form-label">Schedule</label><br>
                                            <span><?php echo $_SESSION['docInfo']['schedule']; ?></span>
                                        </div>
                                    <?php } ?> 
                                    <div class="col-12">
                                        <input type="submit" name="save_coi" value="Save" class="btn btn-primary save-btn d-none">
                                    </div>
                                </form>
                                <?php if($_SESSION['docInfo']['status'] == 'Pending') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary edit-btn coi">Edit</button>
                                    </div>  
                                <?php } else if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary appointment-btn mb-4">Set Appointment</button>
                                    </div>
                                <?php } 
                                
                            } else if($_SESSION['docInfo']['document_type']  == 'Barangay Clearance') { 
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
                            ?>
                                <span class="fs-4 ms-4">Barangay Clearance</span>
                                <form class="row g-3 mx-4 mt-2" method="post" onSubmit="return confirm('Are you sure you want to save these changes?')">
                                <div class="col-md-4">
                                    <label for="date-requested" class="form-label">Date Requested</label><br>
                                    <span><?php echo $_SESSION['docInfo']['date_requested'] ?></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="date-completed" class="form-label">Date Completed</label><br>
                                    <span><?php echo $_SESSION['docInfo']['date_completed'] ?></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="date-completed" class="form-label">Status</label><br>
                                    <span><?php echo $_SESSION['docInfo']['status'] ?></span>
                                </div>
                                    <div class="col-md-6 me-md-2 ">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" disabled
                                            value="<?php echo $row['res_name']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="purpose" class="form-label">Purpose</label><br>
                                        <input type="text" class="form-control editable" name="purpose" id="purpose" disabled required
                                            value="<?php echo $row['purpose']?>">
                                    </div>
                                    <?php if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                        <div class="col-12 mt-4">
                                            <span class="fw-semibold">Appointment Information</span>
                                        </div>
                                        <!-- Datepicker -->
                                        <div class="col-md-6">
                                            <input type="text" class="form-control schedule" id="datepicker" name="datepicker" disabled required="required"
                                                value="<?php if(!empty($_SESSION['docInfo']['schedule'])) {echo $_SESSION['docInfo']['schedule'];}?>" >
                                            <div class="row option mt-4 d-none">
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="08:00:00"><label class="ms-1 fw-semibold">8:00AM - 9:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="09:00:00"><label class="ms-1 fw-semibold">9:00AM - 10:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="10:00:00"><label class="ms-1 fw-semibold">10:00AM - 11:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="11:00:00"><label class="ms-1 fw-semibold">11:00AM - 12:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="13:00:00"><label class="ms-1 fw-semibold">1:00PM - 2:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="14:00:00"><label class="ms-1 fw-semibold">2:00PM - 3:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="15:00:00"><label class="ms-1 fw-semibold">3:00PM - 4:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="16:00:00"><label class="ms-1 fw-semibold">4:00PM - 5:00PM</label>
                                                </div>
                                            </div>
                                        </div>  
                                    <?php } else if ($_SESSION['docInfo']['status'] == 'Claimed') { ?>
                                        <div class="col-md-4 mt-4">
                                            <label for="schedule" class="form-label">Schedule</label><br>
                                            <span><?php echo $_SESSION['docInfo']['schedule']; ?></span>
                                        </div>
                                    <?php } ?> 
                                    <div class="col-12">
                                        <input type="submit" name="save_clearance" value="Save" class="btn btn-primary save-btn d-none">
                                    </div>
                                </form>
                                <?php if($_SESSION['docInfo']['status'] == 'Pending') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary edit-btn">Edit</button>
                                    </div>  
                                <?php } else if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary appointment-btn mb-4">Set Appointment</button>
                                    </div>
                                <?php } 
                                
                            } else if($_SESSION['docInfo']['document_type']  == 'Business Permit') { 
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
                            ?>
                                <span class="fs-4 ms-4">Business Permit</span>
                                <form class="row g-3 mx-4 mt-2" method="post" onSubmit="return confirm('Are you sure you want to save these changes?')">
                                <div class="col-md-4">
                                    <label for="date-requested" class="form-label">Date Requested</label><br>
                                    <span><?php echo $_SESSION['docInfo']['date_requested'] ?></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="date-completed" class="form-label">Date Completed</label><br>
                                    <span><?php echo $_SESSION['docInfo']['date_completed'] ?></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="date-completed" class="form-label">Status</label><br>
                                    <span><?php echo $_SESSION['docInfo']['status'] ?></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="Name" class="form-label">Business Owner</label>
                                    <input type="text" class="form-control" disabled
                                        value="<?php echo $row['business_owner']?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="business-name" class="form-label">Business Name</label>
                                    <input type="text" name="business-name" class="form-control editable" disabled required
                                        value="<?php echo $row['business_name']?>" >
                                </div>
                                <div class="col-md-6">
                                    <label for="business-line" class="form-label">Business Line</label>
                                    <input type="text" name="business-line" class="form-control editable" disabled required
                                        value="<?php echo $row['business_line']?>">
                                </div>
                                <div class="col-12">
                                    <label for="business-address" class="form-label">Business Adress</label>
                                    <input type="text" name="business-address" class="form-control editable" disabled required
                                        value="<?php echo $row['business_address']?>">
                                </div>
                                    <?php if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                        <div class="col-12 mt-4">
                                            <span class="fw-semibold">Appointment Information</span>
                                        </div>
                                        <!-- Datepicker -->
                                        <div class="col-md-6">
                                            <input type="text" class="form-control schedule" id="datepicker" name="datepicker" disabled required="required"
                                                value="<?php if(!empty($_SESSION['docInfo']['schedule'])) {echo $_SESSION['docInfo']['schedule'];}?>" >
                                            <div class="row option mt-4 d-none">
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="08:00:00"><label class="ms-1 fw-semibold">8:00AM - 9:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="09:00:00"><label class="ms-1 fw-semibold">9:00AM - 10:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="10:00:00"><label class="ms-1 fw-semibold">10:00AM - 11:00AM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="11:00:00"><label class="ms-1 fw-semibold">11:00AM - 12:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="13:00:00"><label class="ms-1 fw-semibold">1:00PM - 2:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="14:00:00"><label class="ms-1 fw-semibold">2:00PM - 3:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="15:00:00"><label class="ms-1 fw-semibold">3:00PM - 4:00PM</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" name="time" value="16:00:00"><label class="ms-1 fw-semibold">4:00PM - 5:00PM</label>
                                                </div>
                                            </div>
                                        </div>  
                                    <?php } else if ($_SESSION['docInfo']['status'] == 'Claimed') { ?>
                                        <div class="col-md-4 mt-4">
                                            <label for="schedule" class="form-label">Schedule</label><br>
                                            <span><?php echo $_SESSION['docInfo']['schedule']; ?></span>
                                        </div>
                                    <?php } ?> 
                                    <div class="col-12">
                                        <input type="submit" name="save_permit" value="Save" class="btn btn-primary save-btn d-none">
                                    </div>
                                </form>
                                <?php if($_SESSION['docInfo']['status'] == 'Pending') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary edit-btn">Edit</button>
                                    </div>  
                                <?php } else if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary appointment-btn mb-4">Set Appointment</button>
                                    </div>
                                <?php } 
                                
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- AdminLTE JS link -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('.edit-btn').on('click', function(){
                $('input.editable').removeAttr('disabled');
                $(this).addClass('d-none');
                $('.save-btn').removeClass('d-none');
            });

            $('.edit-btn.coi').on('click', function(){
                $('textarea.editable').removeAttr('disabled');
                $(this).addClass('d-none');
                $('.save-btn').removeClass('d-none');
            });

            $('.appointment-btn').on('click', function(){
                $('input.schedule').removeAttr('disabled');
                $(this).addClass('d-none');
                $('.save-btn').removeClass('d-none');
            });

            var removeDays = ["2023-06-12"]; // global variable
            removeDays = removeDays.concat(<?php echo json_encode($full_slots);?>);
        
            function disabledays(date) {
                var ymd = date.getFullYear() + "-" + String(date.getMonth() + 1).padStart(2, '0') + "-" + String(date.getDate()).padStart(2, '0');
                //disable a list of day
                if ($.inArray(ymd, removeDays) >= 0) {
                    return [false];
                } else {
                    //Show except sundays
                    var day = date.getDay();
                    return [(day == 1 || day == 2 || day == 3 || day == 4 ||day == 5 )];
                }
            }

            $('#datepicker').datepicker({
                beforeShowDay: disabledays,
                minDate: 0
            });
            
            // Function to update the radio buttons with availability
            function updateRadioButtons(date) {
                $.ajax({
                url: 'available_time.php',
                type: 'POST',
                data: {date: date},
                dataType: 'json',
                success: function(response) {
                    
                    // Loop through the radio buttons and update their availability
                    $('input[name="time"]').each(function() {
                        var value = $(this).val();
                        if (response[value] >= 2) {
                            $(this).prop('disabled', true);
                        } else {
                            $(this).prop('disabled', false);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
                });
            }

            // Listen for changes to the datepicker input
            $('#datepicker').on('change', function() {
                // Get the selected date
                var date = $(this).val();
                var dateParts = date.split("/");
                var date = dateParts[2] + "-" + dateParts[0].padStart(2, "0") + "-" + dateParts[1].padStart(2, "0");

                console.log(date);
                // Update the radio buttons with availability
                updateRadioButtons(date);
                $('.option').removeClass('d-none');
            });
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
            $('.img-thumbnail').on('click', function(){
                var imgSrc = $(this).attr('src');
                $('.enlarged-image').attr('src', imgSrc);
                $('#enlargedModal').modal('show');
            });
        });
    </script>
</body>
</html>