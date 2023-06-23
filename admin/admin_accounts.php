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
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed hold-transition overflow-x-hidden">
    <!-- Toast notifications -->
    <div class="toast-container top-0 start-50 translate-middle-x mt-2">
            <div class="toast created text-bg-success align-items-center py-2 pe-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex align-items-centera">
                    <div class="toast-body d-flex align-items-center">
                    <iconify-icon icon="mdi:success-bold" class="fs-4 ms-2 me-3"></iconify-icon>
                    Employee account has been created successfully!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div class="toast email text-bg-info align-items-center py-2 pe-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex align-items-center">
                    <div class="toast-body d-flex align-items-center">
                    <iconify-icon icon="mdi:information" class="fs-4 ms-2 me-3"></iconify-icon>
                    An account with that email already exists. Please try another one.
                    </div>
                    <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <div class="wrapper">
        <?php 
            // If a session is not already started, start a new session
            if(!session_id()){
                session_start(); 
            } 

            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                header("Location: admin_login.php");
                exit();
            }

            include('navbar.php');
            include('sidebar.php');
            include('../dbconfig.php');
            require "../mail.php";

            function generateRandomLetters() {
                $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $result = '';
                for ($i = 0; $i < 6; $i++) {
                    $randomIndex = rand(0, strlen($letters) - 1);
                    $result .= $letters[$randomIndex];
                }
                return $result;
            }

            if(isset($_POST['add-account'])) {
                
                $email = $_POST['email'];
                $role_id = 2;
                $password = generateRandomLetters();
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $firstname = $_POST['f-name'];
                $lastname = $_POST['l-name'];

                $stmt = $conn->prepare("CALL SP_ADD_EMPLOYEE(?, ?, ?, ?, ?)");
                $stmt->bind_param('ssiss', $email, $hash, $role_id, $firstname, $lastname);
                try{ 
                    $stmt->execute();
                    // Check for errors
                    if ($stmt->errno) {
                        echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.email");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
                        die('Failed to call stored procedure: ' . $stmt->error);
                    } else {
                        send_mail($email,"SAM: Account Creation", "Good day!<br><br>Your SAM email account is<br><br>Account Email: ".$email."<br>Password: ".$password."<br><br>Please note that this password is temporary and for security purposes, we require you to change it upon your first login.");
                        echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.created");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
                    }
                } catch (mysqli_sql_exception $e) {
                    echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.email");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';}
            }
            while($conn->next_result()){
                $conn->store_result();
            }

            if(isset($_POST['deactivate']) || isset($_POST['reactivate']) ) {
                
                if(isset($_POST['deactivate'])) {
                    $status = 'deactivated';
                } if(isset($_POST['reactivate'])) {
                    $status = 'active';
                }

                $loginId = $_POST['login_id'];
                $stmt = $conn->prepare("CALL SP_UPDATE_USER_STATUS(?, ?)");
                $stmt->bind_param('is', $loginId, $status);
                $stmt->execute();
            }
        ?>
        <!-- Submit modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p id="confirmationMessage"class="mb-0"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="saveButton"></button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-wrapper mt-0"> 
            <div class="wrapper p-2 mx-md-4 mt-5">
                <div class="card shadow mt-5">
                    <div class="card-header employees-table d-flex justify-content-between">
                        <span class="fs-4 flex-grow-1">Employee Accounts</span>
                        <!-- Button trigger modal -->
                        <div>
                            <button type="button" class="btn border-0 add-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <span class="add-employee"><i class="fa-solid fa-user-plus"></i> Add Employee Account</span>
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title text-dark fs-5" id="exampleModalLabel">Add Employee Account</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                <div class="modal-body text-dark">
                                    <form class="row" action="" method="post">
                                        <!-- Name field -->
                                        <div class="col-md-6">
                                            <label for="Name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="f-name" id="f-name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="l-name" id="l-name" required>
                                        </div>
                                        <!-- Email field -->
                                        <div class="col-12 mt-2">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control rounded-1" required>
                                        </div>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" name="add-account" value="Add Account"/>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive row" id="no-more-tables">
                            <table id="employee" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $stmt = $conn->prepare("CALL SP_GET_ALL_EMPLOYEE");
                                    // Execute the prepared statement
                                    $stmt->execute();
                                    if($stmt) {
                                        // retrieve the result set from the executed statement
                                        $result = $stmt->get_result();  
                                        // fetch the row from the result set
                                        while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td data-title="ID"><?php echo $row['employee_id']; ?></td>
                                                <td data-title="First Name"><?php echo $row['emp_firstname']; ?></td>
                                                <td data-title="Last Name"><?php echo $row['emp_lastname']; ?></td>
                                                <td data-title="Email"><?php echo $row['email']; ?></td>
                                                <td data-title="Status"><?php echo $row['status']; ?></td>
                                                <td data-title="Action">
                                                    <div class="d-flex">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary p-1 me-md-1" data-bs-toggle="modal" data-bs-target="#employee-details-<?php echo $row['employee_id']; ?>">
                                                        View
                                                        </button>
                                                    
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="employee-details-<?php echo $row['employee_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Employee Details</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body row">
                                                                        <div class="col-12 mb-3">
                                                                            <label for="employee-id" class="form-label">Employee ID</label><br>
                                                                            <span><?php echo $row['employee_id']?></span>
                                                                        </div>
                                                                        <!-- Name field -->
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="Name" class="form-label">First Name</label>
                                                                            <input type="text" class="form-control disabled-input" name="f-name" id="f-name" disabled required
                                                                                value="<?php echo $row['emp_firstname']?>">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="Name" class="form-label">Last Name</label>
                                                                            <input type="text" class="form-control disabled-input" name="l-name" id="l-name" disabled required
                                                                                value="<?php echo $row['emp_lastname']?>"/>
                                                                        </div>
                                                                        <!-- Email field -->
                                                                        <div class="col-12 mt-2 mb-3">
                                                                            <label for="email" class="form-label">Email</label>
                                                                            <input type="email" name="email" id="email" class="form-control disabled-input" disabled required
                                                                            value="<?php echo $row['email']?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                        if($row['status'] != 'deactivated') { ?>
                                                        <form method="post">
                                                            <input type="hidden" name="login_id" value="<?php echo $row['login_id'] ?>">
                                                            <input type="hidden" name="deactivate" value="Deactivate"/>
                                                            <input type="submit" name="deactivate" class="btn btn-danger p-1" value="Deactivate"/>
                                                        </form>
                                                    <?php } else { ?>
                                                        <form method="post">
                                                            <input type="hidden" name="login_id" value="<?php echo $row['login_id'] ?>">
                                                            <input type="hidden" name="reactivate" value="Reactivate"/>
                                                            <input type="submit" name="reactivate" class="btn btn-success p-1" value="Reactivate"/>
                                                        </form>
                                                    <?php } ?>
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
            </div>
            <div class="wrapper p-2 mx-md-4 mt-5">
                <div class="card shadow">
                    <div class="card-header residents-table">
                        <span class="fs-4 text-white">Resident Accounts</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive row" id="no-more-tables">
                            <table id="residents" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    while($conn->next_result()) {
                                        $conn->store_result();
                                    }
                    
                                    $stmt = $conn->prepare("CALL SP_GET_ALL_RESIDENT");
                                    // Execute the prepared statement
                                    $stmt->execute();
                                    if($stmt) {
                                        // retrieve the result set from the executed statement
                                        $result = $stmt->get_result();  
                                        // fetch the row from the result set
                                        while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td data-title="ID"><?php echo $row['resident_id']; ?></td>
                                                <td data-title="First Name"><?php echo $row['res_firstname']; ?></td>
                                                <td data-title="Last Name"><?php echo $row['res_lastname']; ?></td>
                                                <td data-title="Email"><?php echo $row['email']; ?></td>
                                                <td data-title="Status"><?php echo $row['status']; ?></td>
                                                <td data-title="Action">
                                                    <div class="d-flex">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary p-1 me-md-1" data-bs-toggle="modal" data-bs-target="#resident-details-<?php echo $row['resident_id']; ?>">
                                                        View
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="resident-details-<?php echo $row['resident_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Resident Details</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body row">
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="resident-id" class="form-label">Resident ID</label><br>
                                                                            <span><?php echo $row['resident_id']?></span>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="status" class="form-label">Status</label><br>
                                                                            <span><?php echo $row['status']?></span>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <label for="date-registered" class="form-label">Date Registered</label><br>
                                                                            <span><?php echo $row['date_registered']?></span>
                                                                        </div>
                                                                        <!-- Name field -->
                                                                        <div class="col-md-6">
                                                                            <label for="Name" class="form-label">First Name</label>
                                                                            <input type="text" class="form-control disabled-input" name="f-name" id="f-name" disabled required
                                                                                value="<?php echo $row['res_firstname']?>">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="Name" class="form-label">Last Name</label>
                                                                            <input type="text" class="form-control disabled-input" name="l-name" id="l-name" disabled required
                                                                                value="<?php echo $row['res_lastname']?>"/>
                                                                        </div>
                                                                        <!-- Email field -->
                                                                        <div class="col-md-7 mt-2 mb-3">
                                                                            <label for="email" class="form-label">Email</label>
                                                                            <input type="email" name="email" id="email" class="form-control disabled-input" disabled required
                                                                            value="<?php echo $row['email']?>">
                                                                        </div>
                                                                        <div class="col-md-5  mt-2 mb-3">
                                                                            <label for="birthdate" class="form-label">Birthdate</label>
                                                                            <input type="text" class="form-control disabled-input" disabled required
                                                                                value="<?php echo $row['birthdate']?>"/>
                                                                        </div>
                                                                        <div class="col-12 mb-3">
                                                                            <label for="address" class="form-label">Address</label>
                                                                            <input type="text" class="form-control disabled-input" disabled required
                                                                                value="<?php echo $row['address']?>"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if($row['status'] != 'deactivated') { ?>
                                                        <form method="post">
                                                            <input type="hidden" name="login_id" value="<?php echo $row['login_id'] ?>">
                                                            <input type="hidden" name="deactivate" value="Deactivate"/>
                                                            <input type="submit" name="deactivate" class="btn btn-danger p-1" value="Deactivate"/>
                                                        </form>
                                                    <?php } else { ?>
                                                        <form method="post">
                                                            <input type="hidden" name="login_id" value="<?php echo $row['login_id'] ?>">
                                                            <input type="hidden" name="reactivate" value="Reactivate"/>
                                                            <input type="submit" name="reactivate" class="btn btn-success p-1" value="Reactivate"/>
                                                        </form>
                                                    <?php } ?>
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
            </div>
        </div>
    </div>

    
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- AdminLTE JS link -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- DataTables JS link -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#employee').DataTable({
            });
            $('#residents').DataTable({
            });

            var formToSubmit;
            $('form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                formToSubmit = $(this); // Store the form that was submitted
                // Retrieve the value of the submit button that triggered the form submission
                var submitButton = event.submitter;
                var submitValue = submitButton.value;
                // Get the appropriate confirmation message based on the action
                var confirmationMessage;
                if (submitValue === 'Deactivate') {
                    confirmationMessage = "Are you sure you want to deactivate this account?";
                } else if (submitValue === 'Reactivate') {
                    confirmationMessage = "Are you sure you want to reactivate this account?";
                }
                // Set the confirmation message in the modal
                var confirmationMessageElement = document.getElementById("confirmationMessage");
                confirmationMessageElement.textContent = confirmationMessage;
                // Set the saveButton value in the modal
                var saveButton = document.getElementById("saveButton");
                saveButton.textContent = submitValue;
                // Display the modal
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