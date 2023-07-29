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
include('../dbconfig.php');
include('schedule_picker.php');
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
    <link rel="stylesheet" href="css/res_services.css">
    <!-- AdminLTE CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- JQuery UI  -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed hold-transition overflow-x-hidden">
    <div class="wrapper">
        <?php
            include('navbar.php');
            include('sidebar.php');
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
                            <a href="res_services.php" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
                                <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
                            </a><br>
                            <?php $doc_id = $_SESSION['docInfo']['doc_id'];
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
                            ?>
                                <span class="fs-4 ms-4">Business Permit</span>
                                <form action="edit_permit.php" class="row g-3 mx-4 mt-2" method="post">
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
                                    <input type="text" name="business-name" class="form-control editable" disabled required
                                        value="<?php echo $row['business_name']?>" >
                                </div>
                                <div class="col-md-12">
                                    <label for="business-address" class="form-label">Business Adress</label>
                                    <input type="text" name="business-address" class="form-control editable" disabled required
                                        value="<?php echo $row['business_address']?>">
                                </div>
                                <input type="hidden" class="form-control" name="document-type" id="document-type" value="business permit">
                                    <?php if($_SESSION['docInfo']['status'] == 'Ready for pick-up') {
                                        displaySchedulePicker();
                                    } else if ($_SESSION['docInfo']['status'] == 'Claimed') { ?>
                                        <div class="col-md-4 mt-4">
                                            <label for="schedule" class="form-label">Schedule</label><br>
                                            <span><?php echo $_SESSION['docInfo']['schedule']; ?></span>
                                        </div>
                                    <?php } ?>
                                    <div class="col-12">
                                        <input type="submit" name="save_permit" value="Save" class="btn btn-primary save-btn d-none">
                                    </div>
                                </form>
                            <?php 
                            if($_SESSION['docInfo']['status'] == 'Pending') { ?>
                                <div class="ms-4 col-12">
                                    <button class="btn btn-primary edit-btn brgy-id mb-4">Edit</button>
                                </div>
                            <?php } else if($_SESSION['docInfo']['status'] == 'Ready for pick-up') { ?>
                                <div class="ms-4 col-12">
                                    <button class="btn btn-primary appointment-btn mb-4">Set Appointment</button>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php function displayDocInfo() { ?>
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
        <span><?php echo $_SESSION['docInfo']['expiry_date'] ?></span>
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
            $('.edit-btn').on('click', function(){
                $('input.editable').removeAttr('disabled');
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

            // confirmation modal
            var formToSubmit;
            // Show the confirmation modal when any form is submitted
            $('form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                formToSubmit = $(this); // Store the form that was submitted
                $('#confirmationModal').modal('show');
            });

            // Handle the click event of the Save button in the modal
            $('#saveButton').on('click', function() {
                $('#confirmationModal').modal('hide');
                formToSubmit.off('submit').submit();
            });

        });
    </script>
</body>
</html>