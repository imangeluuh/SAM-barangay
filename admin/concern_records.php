<?php 
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
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed hold-transition overflow-x-hidden">
        <div class="wrapper">
        <?php 
            include('navbar.php');
            include('sidebar.php');
            include('../dbconfig.php');
            
            $stmt = $conn->prepare("CALL SP_GET_IP_REPORT");
        ?>
        <div class="content-wrapper">
            <?php
                // Fetch any remaining result sets
                while($conn->next_result()) {
                    $conn->store_result();
                }
                $stmt = $conn->prepare("CALL SP_GET_ALL_REPORTS");
                // Execute the prepared statement
                $stmt->execute();
            ?>
            <div class="wrapper p-5 mt-3">
                <div class="card shadow">
                    <div class="card-header completed-header">
                        <span class="fs-4 ">Concern Reports</span>
                    </div>
                    <div class="card-body p-3">                
                        <div class="table-responsive mt-3" id="no-more-tables">
                            <table id="table3" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Report Type</th>
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
                                                    <td data-title="ID"><?php echo $row['report_id']; ?></td>
                                                    <td data-title="Date"><?php echo $row['date_reported']; ?></td>
                                                    <td data-title="Details"><?php echo $row['report_type']; ?></td>
                                                    <td data-title="Action">
                                                        <form action="view_report.php" method="post">
                                                            <input type="hidden" name="report_id" value="<?php echo $row['report_id']; ?>">
                                                            <input type="hidden" name="date_reported" value="<?php echo $row['date_reported']; ?>">
                                                            <input type="hidden" name="date_resolved" value="<?php echo $row['date_resolved']; ?>">
                                                            <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                                                            <input type="hidden" name="image_name" value="<?php echo $row['image_name']; ?>">
                                                            <input type="hidden" name="image" value="<?php echo htmlspecialchars($row['image']); ?>">
                                                            <input type="hidden" name="resident_id" value="<?php echo $row['resident_id']; ?>">
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
            $('#table3').DataTable({
                "order": [[ 1, "desc"]],
            });
        });
    </script>
</body>
</html>