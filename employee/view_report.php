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
    <link rel="stylesheet" href="css/emp_doc_req.css">
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
                $reportInfo = array('report_id' => $_POST['report_id']
                                    , 'date_resolved' =>  $_POST['date_resolved'] == NULL ? 'N/A' : $_POST['date_resolved']
                                    , 'status' => $_POST['status']
                                    , 'image_name' => !empty($_POST['image_name']) ? $_POST['image_name'] : NULL
                                    , 'image' => !empty($_POST['image']) ? $_POST['image'] : NULL
                                    , 'resident_id' => $_POST['resident_id']);
                // Store the user data array in the $_SESSION variable for future use.
                $_SESSION['reportInfo'] = $reportInfo;

                $stmt = $conn->prepare("CALL SP_GET_RESIDENT(?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('i', $_SESSION['reportInfo']['resident_id']);
                // Execute the prepared statement
                $stmt->execute();  
                if($stmt) {
                    // retrieve the result set from the executed statement
                    $result = $stmt->get_result();  
                    // fetch the row from the result set
                    $row = $result->fetch_assoc();
                    $reportInfo += array('res_name' => $row['res_firstname'] . " " .  $row['res_lastname']
                                        , 'res_address' => $row['address']);
                    $_SESSION['reportInfo'] = $reportInfo;
                }
            }
        ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-12 mx-5 mt-4">
                            <!-- Submit modal -->
                            <div class="modal fade" id="confirmationModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p class="mb-0">Are you sure you want to save these changes?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="emp_report_concern.php" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
                                <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
                            </a><br>
                            <?php
                                while($conn->next_result()) {
                                    $conn->store_result();
                                }
                                $stmt = $conn->prepare("CALL SP_GET_REPORT(?)");
                                // bind the input parameters to the prepared statement
                                $stmt->bind_param('i', $_SESSION['reportInfo']['report_id']);
                                // Execute the prepared statement
                                $stmt->execute();
                                // retrieve the result set from the executed statement
                                $result = $stmt->get_result();  
                                // fetch the row from the result set
                                $row = $result->fetch_assoc();
                            ?>
                                <div class="row g-3 mx-4 mt-2">
                                    <div class="col-md-4">
                                        <label for="date-reported" class="form-label">Date Reported</label><br>
                                        <span name="date-reported"><?php echo $row['date_reported'] ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date-resolved" class="form-label">Date Resolved</label><br>
                                        <span><?php echo $_SESSION['reportInfo']['date_resolved'] ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status</label><br>
                                        <span><?php echo $_SESSION['reportInfo']['status'] ?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" disabled
                                            value="<?php echo $_SESSION['reportInfo']['res_name']?>">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" disabled
                                            value="<?php echo $_SESSION['reportInfo']['res_address']?>">
                                    </div>
                                    <div class="col-6">
                                        <label for="report-details" class="form-label">Report Type</label><br>
                                        <input type="text" class="form-control editable" name="report-type" id="report=type" disabled
                                            value="<?php echo $row['report_type']?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="report-details" class="form-label">Narrative Report of Concern</label><br>
                                        <textarea name="report-details" id="report-details" class="editable" disabled required><?php
                                            echo $row['report_details'];
                                        ?></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="report-loc" class="form-label">Location of Reported Concern</label><br>
                                        <textarea name="report-loc" id="report-loc" class="editable" disabled required><?php
                                            echo $row['report_loc'];
                                        ?></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="image" class="form-label">Uploaded Image of Concern</label><br>
                                        <div class="img-box">
                                        <?php if ($row['image'] != NULL): 
                                            echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" class="img-thumbnail"/>';
                                        endif; ?>
                                        </div>
                                    </div>
                                    <?php if($row['status'] != 'Resolved') { ?>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary mt-2 mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Update Status</button>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Status</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="statusForm" action="update_report.php" method="post">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="select-status" class="col-form-label">Select Status</label>
                                                                    <select class="form-select" name="status" required>
                                                                        <option selected disabled value="">Select an option</option>
                                                                        <option value="In Progress">In Progress</option>
                                                                        <option value="Resolved">Resolved</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="submit" name="update" value="Save" class="btn btn-primary save-btn">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                <?php } ?>
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

            // Show the confirmation modal when any form is submitted
            $('#statusForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                $('#exampleModal').modal('hide');
                $('#confirmationModal').modal('show');
            });

            // Handle the click event of the Save button in the modal
            $('#saveButton').on('click', function() { 
                $('#confirmationModal').modal('hide');
                $('#statusForm').off('submit').submit();
            });

        });
    </script>
</body>
</html>