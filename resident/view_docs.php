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
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
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
                                            , 'doc_id' => $_POST['doc_id']);

                // Store the user data array in the $_SESSION variable for future use.
                $_SESSION['docInfo'] = $docInfo;
            }

            if(isset($_POST['save_id'])) { 
                // Fetch any remaining result sets
                while($conn->next_result()) {
                    $conn->store_result();
                }
                
                $birthplace = $_POST['birthplace'];
                $height = $_POST['height'];
                $weight = $_POST['weight'];
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
                
                $background_info = trim($_POST['background-info']);
                $purpose = trim($_POST['purpose']);
        
                $stmt = $conn->prepare("CALL SP_UPDATE_COI(?, ?, ?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('iss', $_SESSION['docInfo']['doc_id'], $background_info, $purpose);
                // Execute the prepared statement
                $stmt->execute();  
                
                // Close the prepared statement and database connection
                $stmt->close();
                $conn->close();
                
                header("Location: view_docs.php");
                exit();
            }
        ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-12 mx-5 mt-4">
                            <a href="res_services.php" class="w-25 ms-4 d-flex align-items-center text-decoration-none text-secondary">
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
                                
                                <form class="row g-3 mx-4 mt-2" action="" method="post" onSubmit="return confirm('Are you sure you want to save these changes?')">
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
                                            value="<?php echo $_SESSION['userData']['res_firstname'] . ' ' . $_SESSION['userData']['res_middlename'][0] . '. ' . $_SESSION['userData']['res_lastname']?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Birthdate" class="form-label">Birthdate</label>
                                        <input type="date" class="form-control" id="birthdate" disabled
                                            value="<?php echo $_SESSION['userData']['birthdate'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Birthplace" class="form-label">Place of Birth</label>
                                        <input type="text" class="form-control editable" id="birthplace" name="birthplace" disabled required="required"
                                            value="<?php echo $row['res_birthplace']?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" disabled value="<?php echo $_SESSION['userData']['address'] ?>">
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
                                        <input type="text" class="form-control editable" id="religion" name="religion" disabled value="<?php echo $row['res_religion']?>">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <span class="text-danger fw-semibold">In case of emergency, please notify:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="emergency-contact" class="form-label">Name</label>
                                        <input type="text" class="form-control editable" id="contact-name" name="contact-name" required="required" disabled value="<?php echo $row['contact_name']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact-telephone" class="form-label">Telephone</label>
                                        <input type="text" class="form-control editable" id="contact-no" name="contact-no" disabled required="required" value="<?php echo $row['contact_no']?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control editable" id="contact-address" name="contact-address" disabled required="required"  value="<?php echo $row['contact_address']?>">
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" name="save_id" value="Save" class="btn btn-primary save-btn d-none">
                                    </div>
                                </form>
                                <?php if($_SESSION['docInfo']['status'] == 'Pending') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary edit-btn brgy-id">Edit</button>
                                    </div>  
                                <?php } ?>  
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
                            ?>
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
                                        <textarea class="editable" name="background-info" id="background-info" cols="100" rows="5" disabled required="required"><?php
                                            echo $row['background_info']
                                        ?></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="purpose" class="form-label">Purpose</label><br>
                                        <textarea class="editable" name="purpose" id="purpose" cols="100" rows="2" disabled required="required"><?php
                                            echo $row['purpose']
                                        ?></textarea>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" name="save_coi" value="Save" class="btn btn-primary save-btn d-none">
                                    </div>
                                </form>
                                <?php if($_SESSION['docInfo']['status'] == 'Pending') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary edit-btn coi">Edit</button>
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
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- AdminLTE JS link -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- DataTables JS link -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.edit-btn.brgy-id').on('click', function(){
                $('input.editable').removeAttr('disabled');
                $(this).addClass('d-none');
                $('.save-btn').removeClass('d-none');
            });

            $('.edit-btn.coi').on('click', function(){
                $('textarea.editable').removeAttr('disabled');
                $(this).addClass('d-none');
                $('.save-btn').removeClass('d-none');
            });
        });

    </script>
</body>
</html>