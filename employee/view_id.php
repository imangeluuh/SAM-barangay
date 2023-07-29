<?php
if(!session_id()){
    session_start(); 
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}
include('../dbconfig.php');
require_once "../language/" . $_SESSION['lang'] . ".php";
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
    <link rel="stylesheet" href="css/emp_doc_req.css">
    <!-- AdminLTE CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed hold-transition overflow-x-hidden">
    <div class="wrapper">
        <?php
        include('navbar.php');
        include('sidebar.php');
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
                            <a href="./emp_doc_req.php" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
                                <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
                            </a><br>
                            <?php
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
                                    <a href="fill_id_form.php" target="_blank" class="btn btn-success me-5 px-4"style="width: fit-content">Print</a>  
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
                                    <?php if ($_SESSION['docInfo']['schedule'] != NULL) { ?>
                                        <div class="col-md-4 mt-4 pb-3">
                                        <label for="schedule" class="form-label">Schedule</label><br>
                                            <span><?php echo $_SESSION['docInfo']['schedule']; ?></span>
                                        </div> 
                                        <?php date_default_timezone_set('Asia/Singapore');
                                        if(strtotime(date("Y-m-d")) >= strtotime(date("Y-m-d", strtotime($_SESSION['docInfo']['schedule']))) && $row['status'] != 'Claimed') { ?>
                                        <div class="col-12 pb-3">
                                            <form action="update_request.php" method="post">
                                                <input type="hidden" name="status" value="Claimed">
                                                <button type="submit" class="btn btn-primary">Claimed</button>
                                            </form>
                                        </div>
                                        <?php }
                                        } 
                                        if ($_SESSION['docInfo']['status'] == 'Pending') { ?>
                                            <div class="col-12">
                                                <form id="statusForm" action="update_request.php" method="post">
                                                    <input type="hidden" name="status" id="status" value="Ready for pick-up">
                                                    <input type="submit" name="update" value="Ready for pick-up" class="btn btn-primary mt-2 mb-5">
                                                </form>
                                            </div>
                                        <?php } ?> 
                                </div>
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
    
    <script>
        $(document).ready(function () {
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