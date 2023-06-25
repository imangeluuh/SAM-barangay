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
                                    , 'image_name' => !empty($_POST['image_name']) ? $_POST['image_name'] : NULL
                                    , 'image' => !empty($_POST['image']) ? $_POST['image'] : NULL);

                // Store the user data array in the $_SESSION variable for future use.
                $_SESSION['reportInfo'] = $reportInfo;
            }

            if(isset($_POST['submit-report'])) {
                $reportType = $_POST['report-type'];
                $report_details = $_POST['report-details'];
                $report_loc = $_POST['report-loc'];

                $fileName = !empty($_FILES["image"]["name"]) ?  basename($_FILES["image"]["name"]) : $_SESSION['reportInfo']['image_name'];
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                    
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg'); 
                if($fileName != NULL && !in_array($fileType, $allowTypes)){ 
                    echo "<script>alert('Sorry, only JPG, JPEG, & PNG files are allowed to upload.');</script>";
                    exit();
                } else {
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = !empty($_FILES["image"]["name"]) ? file_get_contents($image) : NULL; 
                    
            
                    try {
                        $stmt = $conn->prepare("CALL SP_UPDATE_REPORT(?, ?, ?, ?, ?, ?)");
                        // bind the input parameters to the prepared statement
                        $stmt->bind_param('isssss', $_SESSION['reportInfo']['report_id'], $reportType, $report_details, $report_loc, $fileName, $imgContent);
                        // Execute the prepared statement
                        $stmt->execute();   

                        if ($stmt) {
                            echo "<script>alert('Updates have been successfully saved!');</script>";
                            exit();
                        }
                    } catch (mysqli_sql_exception $e) {
                        echo "<script>alert('File upload failed, please try again.');</script>s";
                        exit();
                    }
                }
            }
        ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-12 mx-5 mt-4">
                            <a href="res_services.php" class="ms-4 d-flex align-items-center text-decoration-none text-secondary">
                                <i class="fa-solid fa-angle-left me-3"></i><?php echo $lang['go_back'] ?>
                            </a><br>
                            <?php
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
                                <form class="row g-3 mx-4 mt-2" method="post" enctype="multipart/form-data" onSubmit="return confirm('Are you sure you want to save these changes?')">
                                    <div class="col-md-12">
                                        <label for="date-requested" class="form-label">Date Reported</label><br>
                                        <span><?php echo $row['date_reported'] ?></span>
                                    </div>
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
                                    <div class="col-md-6">
                                        <label for="image" class="form-label">Upload Image of Concern</label><br>
                                        <div class="d-flex">
                                            <input type='file' name="image" id="image" class="form-control rounded-end-0 editable" disabled onchange="pressed()">
                                            <label id="fileLabel" class="form-control fw-normal rounded-start-0"><?php echo $row['image_name'] ?></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" name="submit-report" class="save-btn btn btn-primary d-none">Submit</button>
                                    </div>
                                </form>
                                <?php if($row['status'] == 'Pending') { ?>
                                    <div class="ms-4 col-12">
                                        <button class="btn btn-primary edit-btn brgy-id mb-4">Edit</button>
                                    </div>  
                                <?php } 
                            ?>
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
            $('.edit-btn').on('click', function(){
                $('.editable').removeAttr('disabled');
                $(this).addClass('d-none');
                $('.save-btn').removeClass('d-none');
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

        });
    </script>
</body>
</html>