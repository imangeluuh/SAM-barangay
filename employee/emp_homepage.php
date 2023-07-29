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
    <link rel="stylesheet" href="../css/about_us.css">
    <!-- AdminLTE CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- DataTable CSS link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed hold-transition overflow-x-hidden">
    <div class="wrapper">
        <?php 
            // If a session is not already started, start a new session
            if(!session_id()){
                session_start(); 
            } 

            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                header("Location: ../index.php");
                exit;
            }

            $_SESSION['lang'] = 'en';

            include('navbar.php');
            include('sidebar.php');
            include('../dbconfig.php');

            $stmt = $conn->prepare("CALL SP_GET_PICK_UP_TODAY");
            // Execute the prepared statement
            $stmt->execute();
        ?>

        <div class="content-wrapper" style="background-color: #ffffff!important">
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
            <div class="wrapper p-5 mt-5">
                <div class="card shadow">
                    <div class="card-header inprogress-header">
                        <span class="fs-4">Today's Schedule</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive mt-3" id="no-more-tables">
                            <table id="schedToday" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Document Type</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($stmt) {
                                            // retrieve the result set from the executed statement
                                            $result = $stmt->get_result();  
                                            // fetch the row from the result set
                                            while($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td data-title="ID"><?php echo $row['request_id']; ?></td>
                                                    <td data-title="Document Type"><?php echo $row['document_type']; ?></td>
                                                    <td data-title="Time"><?php echo getTime($row['schedule']); ?></td>
                                                    <td data-title="Action">
                                                        <div class="d-flex">
                                                        <form action="view_docs.php" method="post">
                                                            <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                                            <input type="hidden" name="document_type" value="<?php echo $row['document_type']; ?>">
                                                            <input type="hidden" name="date_requested" value="<?php echo $row['date_requested']; ?>">
                                                            <input type="hidden" name="date_completed" value="<?php echo $row['date_completed']; ?>">
                                                            <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                                                            <input type="hidden" name="doc_id" value="<?php echo $row['doc_id']; ?>">
                                                            <input type="hidden" name="schedule" value="<?php echo $row['schedule']; ?>">
                                                            <input type="submit" name="view"
                                                                    class="btn btn-primary p-0 px-1 me-1" value="View" />
                                                        </form>
                                                        <form id="claimForm" action="claim_docs.php" method="post">
                                                            <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                                            <input type="hidden" name="status" value="Claimed">
                                                            <input type="submit" name="claimed" class="btn btn-success p-0 px-1" value="Claimed"> 
                                                        </form>
                                                    </td>
                                                    </div>
                                            </tr>
                                            <?php }
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper px-5">
                <div class="card shadow">
                    <div class="card-header inprogress-header">
                        <span class="fs-4">Current Week's Schedule</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive mt-3" id="no-more-tables">
                            <table id="schedWeek" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Document Type</th>
                                        <th>Schedule</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch any remaining result sets
                                    while($conn->next_result()) {
                                        $conn->store_result();
                                    }
                                    $stmt = $conn->prepare("CALL SP_GET_PICK_UP_WEEK");
                                    // Execute the prepared statement
                                    $stmt->execute();
                                        if($stmt) {
                                            // retrieve the result set from the executed statement
                                            $result = $stmt->get_result();  
                                            // fetch the row from the result set
                                            while($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td data-title="ID"><?php echo $row['request_id']; ?></td>
                                                    <td data-title="Document Type"><?php echo $row['document_type']; ?></td>
                                                    <td data-title="Schedule"><?php echo $row['schedule']; ?></td>
                                                    <td data-title="Action">
                                                        <form action="view_docs.php" method="post">
                                                            <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                                            <input type="hidden" name="document_type" value="<?php echo $row['document_type']; ?>">
                                                            <input type="hidden" name="date_requested" value="<?php echo $row['date_requested']; ?>">
                                                            <input type="hidden" name="date_completed" value="<?php echo $row['date_completed']; ?>">
                                                            <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                                                            <input type="hidden" name="doc_id" value="<?php echo $row['doc_id']; ?>">
                                                            <input type="hidden" name="schedule" value="<?php echo $row['schedule']; ?>">
                                                            <input type="submit" name="view"
                                                                    class="btn btn-primary p-0 px-1" value="View" />
                                                        </form> 
                                                    </td>
                                            </tr>
                                            <?php }
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <?php
    function getTime($schedule) {
    // Create a DateTime object from the datetime string
    $datetime = new DateTime($schedule);

    // Extract the time portion
    $time = $datetime->format('H:i:s');

    // Convert the time to 12-hour format
    $time12Hour = date('h:i A', strtotime($time));

    return $time12Hour;
    }
    ?>
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
            $('#schedToday').DataTable({
                "order": [[ 2, "asc"]],
            });

            $('#schedWeek').DataTable({
                "order": [[ 2, "asc"]],
            });

            $('#claimForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                $('#confirmationModal').modal('show');
            });

            // Handle the click event of the Save button in the modal
            $('#saveButton').on('click', function() { 
                $('#confirmationModal').modal('hide');
                $('#claimForm').off('submit').submit();
            });
        });
    </script>
</body>
</html>