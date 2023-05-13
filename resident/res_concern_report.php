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

        ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 mt-5">

                        <?php 
                        if(isset($_POST['submit-report'])) {
                            $reportType = $_POST['report-type'];
                            $report_details = $_POST['report-details'];
                            $report_loc = $_POST['report-loc'];

                            $fileName = basename($_FILES["image"]["name"]); 
                            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                            
                            // Allow certain file formats 
                            $allowTypes = array('jpg','png','jpeg','gif'); 
                            if($fileName != NULL && !in_array($fileType, $allowTypes)){ 
                                echo "<script>alert('Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.');</script>";
                                exit();
                            } else {
                                $image = $_FILES['image']['tmp_name']; 
                                $imgContent = !empty($_FILES["image"]["name"]) ? addslashes(file_get_contents($image)) : NULL; 
                        
                                try {
                                    $stmt = $conn->prepare("CALL SP_ADD_REPORT(?, ?, ?, ?, ?, ?)");
                                    // bind the input parameters to the prepared statement
                                    $stmt->bind_param('sssssi', $reportType, $report_details, $report_loc, $fileName, $imgContent, $_SESSION['userData']['resident_id'],);
                                    // Execute the prepared statement
                                    $stmt->execute();   
            
                                    if ($stmt) {
                                        echo "<script>alert('Thank you for submitting your concern. Our team will review your report and take the necessary actions. We appreciate your cooperation in helping us improve our community.'); window.location.href = 'res_services.php';</script>";
                                        exit();
                                    }
                                } catch (mysqli_sql_exception $e) {
                                    echo "<script>alert('File upload failed, please try again.');</script>";
                                    exit();
                                }
                            }
                        }
                        
                        ?>

                        <a href="javascript:history.back()" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
                        <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
                        </a><br>

                            <span class="fs-4 ms-4">Report Concern</span>
                            <form class="row g-3 mx-4 mt-2" method="post" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <label for="Name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" disabled
                                        value="<?php echo $_SESSION['userData']['res_firstname'] . " ";
                                                    if (!empty($_SESSION['userData']['res_middlename'])) { echo $_SESSION['userData']['res_middlename'][0] . '. ';}
                                                    echo $_SESSION['userData']['res_lastname']?>">
                                </div>
                                <div class="col-md-6">
                                <label for="Address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" disabled
                                        value="<?php echo $_SESSION['userData']['address']?>">
                                </div>
                                <div class="col-6">
                                    <label for="report-type" class="form-label">Report Type</label><br>
                                    <input type="text" class="form-control" name="report-type" id="report-type">
                                </div>
                                <div class="col-12">
                                    <label for="report-details" class="form-label">Narrative Report of Concern</label><br>
                                    <textarea name="report-details" id="report-details" cols="135" rows="5" required="required"></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="report-loc" class="form-label">Location of Reported Concern</label><br>
                                    <textarea name="report-loc" id="report-loc" cols="135" rows="2" required="required"></textarea>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <label for="image" class="form-label">Upload Image of Concern</label><br>
                                        <input type='file' name="image" id="image" class="editable" required onchange="pressed()">
                                        <label id="fileLabel" class="fw-normal">No file chosen</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="submit-report" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
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

        });
    </script>
</body>
</html>