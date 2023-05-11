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
            
            $stmt = $conn->prepare("CALL SP_GET_REQUEST(?)");

            // bind the input parameters to the prepared statement
            $stmt->bind_param('i', $_SESSION['userData']['resident_id']);

            // Execute the prepared statement
            $stmt->execute();

        ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-2 mx-5 text-center">
                            <a type="button" href="res_doc_req.php" class="btn btn-primary mt-5 border-0" style="padding:60px;border-radius:25px; width:230px; background:#004368;">
                                <h4 class="font-weight-bold">Document<br>Request</h4>
                            </a>
                        </div>
                        <div class="col-lg-2 mx-5 text-center">
                            <a type="button" href="" class="btn btn-primary mt-5 border-0" style="padding:60px;border-radius:25px; width:230px; background:#004368;">
                                <h4 class="font-weight-bold">Report<br>Concern</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper p-5 mt-3">
                <span class="fs-4 history">Transaction History</span>
                <div class="table-responsive mt-3" id="no-more-tables">
                    <table id="example" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Schedule</th>
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
                                            <td data-title="Date"><?php echo $row['date_requested']; ?></td>
                                            <td data-title="Type"><?php echo 'Document'; ?></td>
                                            <td data-title="Details"><?php echo $row['document_type']; ?></td>
                                            <td data-title="Status"><?php echo $row['status']; ?></td>
                                            <td data-title="Status"><?php echo $row['schedule']; ?></td>
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
                                                            class="btn text-primary p-0" value="View" />
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
            $('#example').DataTable();
        });
    </script>
</body>
</html>