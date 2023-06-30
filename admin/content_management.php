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
    <link rel="stylesheet" href="css/content_management.css">
    <!-- AdminLTE CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- DataTables CSS link -->
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
                header("Location: admin_login.php");
                exit;
            }

            include('navbar.php');
            include('sidebar.php');
        ?>
        <div class="content-wrapper">
            <div class="content h-100 p-0">
                <div class="container-fluid h-100 p-0">
                    <div class="row mb-5 mx-5">
                        <div class="row pt-4">
                            <div class="col-12">
                                <h2>System Configuration Panel</h2>
                            </div>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">About Us</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">FAQs</button>
                            </li>
                        </ul>
                        <div class="tab-content bg-white" id="myTabContent">
                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">
                                <!-- About Us -->
                                <div class="form-group mt-2">
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <h5>Citizen's Charter</h5>
                                        <!-- Button trigger modal -->
                                        <div>
                                            <button type="button" class="btn btn-info border-0" data-bs-toggle="modal" data-bs-target="#addModal">
                                                <span class="add">Add Record</span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title text-dark fs-5" id="addModalLabel">Add Record</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            <div class="modal-body text-dark">
                                                <form action="view_ccharter.php" method="post">
                                                    <div class="col-12 mb-3">
                                                        <label for="Name" class="form-label">Image Code</label>
                                                        <input type="text" class="form-control" name="image" id="image" required>
                                                    </div>
                                            </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <input type="submit" class="btn btn-primary" name="save" value="Save"/>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3" id="no-more-tables">
                                        <table id="table1" class="table table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Image Code</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $stmt = $conn->prepare("CALL SP_GET_CCHARTER");
                                                $stmt->execute();
                                                if($stmt) {
                                                    // retrieve the result set from the executed statement
                                                    $result = $stmt->get_result();  
                                                    // fetch the row from the result set
                                                    while($row = $result->fetch_assoc()) { ?>
                                                            <tr>
                                                                <td data-title="ID"><?php echo $row['image_id']; ?></td>
                                                                <td data-title="Image Code"><?php echo $row['image']; ?></td>
                                                                <td data-title="Action">
                                                                    <div class="d-flex">                                                                        
                                                                        <!-- Edit Button trigger modal -->
                                                                        <button type="button" class="badge-warning border-0 rounded-3 p-1 px-2" data-bs-toggle="modal" data-bs-target="#employee-details-<?php echo $row['image_id']; ?>">
                                                                        Edit
                                                                        </button>
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="employee-details-<?php echo $row['image_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-body row">
                                                                                        <form action="view_ccharter.php" method="post">
                                                                                            <div class="col-12 mb-3">
                                                                                                <label for="employee-id" class="form-label">Image ID</label><br>
                                                                                                <input type="hidden" name="image_id" value="<?php echo $row['image_id']?>">
                                                                                                <span><?php echo $row['image_id']?></span>
                                                                                            </div>
                                                                                            <div class="col-12 mb-3">
                                                                                                <label for="Name" class="form-label">Image Code</label>
                                                                                                <input type="text" class="form-control" name="image" id="image" required
                                                                                                    value="<?php echo $row['image']?>">
                                                                                            </div>
                                                                                            <div class="col-12">
                                                                                                <input type="submit" name="edit" value="Save" class="btn btn-primary">
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <form action="view_ccharter.php" method="post" class="mx-1">
                                                                            <input type="hidden" name="image_id" value="<?php echo $row['image_id']; ?>">
                                                                            <input type="submit" name="delete"
                                                                                    class="badge-danger border-0 rounded-3 p-1 px-2" value="Delete" />
                                                                        </form> 
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    } ?>
                                            </tbody>
                                        </table>
                                    </div> 
                                    <div class="d-flex justify-content-between mt-3">
                                        <h5>SAM Description</h5>
                                        <!-- Button trigger modal -->
                                        <div>
                                            <button type="button" class="btn btn-info border-0" data-bs-toggle="modal" data-bs-target="#addDescModal">
                                                <span class="add">Add Description</span>
                                            </button>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="addDescModal" tabindex="-1" aria-labelledby="addDescModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title text-dark fs-5" id="addModalLabel">Add Description</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                <div class="modal-body text-dark">
                                                    <form action="process_system_details.php" method="post">
                                                        <div class="col-12 mb-3">
                                                            <label for="Name" class="form-label">Detail Name</label>
                                                            <input type="text" class="form-control" name="detail-name" id="detail-name" required>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="Name" class="form-label">Details</label><br>
                                                            <textarea name="details" id="details" rows="6" required></textarea>
                                                        </div>
                                                </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <input type="submit" class="btn btn-primary" name="save" value="Save"/>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3" id="no-more-tables">
                                        <table id="table1" class="table table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Details</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                while($conn->next_result()) {
                                                    $conn->store_result();
                                                }
                                                $stmt = $conn->prepare("CALL SP_GET_ALL_DETAILS");
                                                $stmt->execute();
                                                if($stmt) {
                                                    // retrieve the result set from the executed statement
                                                    $result = $stmt->get_result();  
                                                    // fetch the row from the result set
                                                    while($row = $result->fetch_assoc()) { ?>
                                                            <tr>
                                                                <td data-title="ID"><?php echo $row['detail_id']; ?></td>
                                                                <td data-title="Details" class="text-truncate" style="max-width: 300px;"><?php echo $row['details']; ?></td>
                                                                <td data-title="Action">
                                                                    <div class="d-flex">
                                                                        <!-- Edit Button trigger modal -->
                                                                        <button type="button" class="badge-warning border-0 rounded-3 p-1 px-2" data-bs-toggle="modal" data-bs-target="#system-details-<?php echo $row['detail_id']; ?>">
                                                                        Edit
                                                                        </button>
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="system-details-<?php echo $row['detail_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-body row">
                                                                                        <form action="process_system_details.php" method="post">
                                                                                            <div class="col-12 mb-3">
                                                                                                <label for="employee-id" class="form-label">Detail ID</label><br>
                                                                                                <input type="hidden" name="detail_id" value="<?php echo $row['detail_id']?>">
                                                                                                <span><?php echo $row['detail_id']?></span>
                                                                                            </div>
                                                                                            <div class="col-12 mb-3">
                                                                                                <label for="Name" class="form-label">Detail Name</label>
                                                                                                <input type="text" class="form-control" name="detail-name" id="detail-name" required
                                                                                                    value="<?php echo $row['detail_name']?>">
                                                                                            </div>
                                                                                            <div class="col-12 mb-3">
                                                                                                <label for="Name" class="form-label">Details</label><br>
                                                                                                <textarea name="details" id="details" rows="6" required><?php
                                                                                                    echo $row['details'];
                                                                                                ?></textarea>
                                                                                            </div>
                                                                                            <div class="col-12">
                                                                                                <input type="submit" name="edit" value="Save" class="btn btn-primary">
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <form action="process_system_details.php" method="post" class="mx-1">
                                                                            <input type="hidden" name="detail_id" value="<?php echo $row['detail_id']; ?>">
                                                                            <input type="submit" name="delete"
                                                                                    class="badge-danger border-0 rounded-3 p-1 px-2" value="Delete" />
                                                                        </form> 
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    } ?>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                                <?php include('faqs_content.php'); ?>
                            </div>
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
</body>
</html>