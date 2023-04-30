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
    <link rel="stylesheet" href="css/res_homepage.css">
    <!-- AdminLTE CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
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
        ?>
        <div class="content-wrapper">
            <div class="content p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 p-0 mt-5">
                            <div class="first-container row mb-5">
                                <div class="sam-img col-md-5 d-flex justify-content-center justify-content-md-end p-0">
                                    <img src="../sam.png" alt="" class="sam pe-md-5">
                                </div>
                                <div class="first-btn col-md-7 d-flex justify-content-center justify-content-md-start  pe-md-5">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <span class="concern-txt"><?php echo $lang['q_concern'] ?></span>
                                        <span class="help-txt"><?php echo $lang['can_help'] ?></span>
                                        <div class="btn-container d-flex justify-content-center align-items-center">
                                            <a href="" class="sam-btn text-white fw-semibold text-decoration-none"><?php echo $lang['lead_to_sam'] ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="second-container row py-md-3 px-md-5 m-0 mb-5">
                                <span class="process-txt fs-5 mb-3 px-md-5"><?php echo $lang['we_process'] ?>:</span>
                                <div class="services row text-white d-flex justify-content-around px-md-5">
                                    <div class="col-md-2 col-sm-6 mb-2 d-flex flex-column justify-content-center align-items-center p-4 px-5 mx-1 rounded-3 services-box">
                                        <p class="pt-2 m-0">Barangay</p>
                                        <p class="pb-2">ID</p>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-2 d-flex flex-column justify-content-center align-items-center mx-1 rounded-3 services-box">
                                        <p class="pt-2 m-0">Barangay</p>
                                        <p class="pb-2">Clearance</p>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-2 d-flex flex-column justify-content-center align-items-center mx-1 rounded-3 services-box">
                                        <p class="pt-2 m-0">Certificate</p>
                                        <p class="m-0">of</p>
                                        <p class="pb-2">Indigency</p>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-2 d-flex flex-column justify-content-center align-items-center mx-1 rounded-3 services-box">
                                        <p class="pt-2 m-0">Certificate</p>
                                        <p class="m-0">of</p>
                                        <p class="pb-2">Residency</p>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-2 d-flex flex-column justify-content-center align-items-center p-4 px-5 mx-1 rounded-3 services-box">
                                        <p class="pt-2 m-0">Business</p>
                                        <p class="pb-2">Permit</p>
                                    </div>
                                </div>
                            </div>
                            <div class="third-container row">
                                <div class="col-md-6 d-flex justify-content-center justify-content-md-end align-items-center">
                                    <div class="d-flex flex-column pe-md-5">
                                        <span class="fs-1 fw-semibold"><?php echo $lang['brgy_issues'] ?></span>
                                        <span class="fs-5 fw-semibold mb-2"><?php echo $lang['we_hear'] ?>.</span>
                                        <div class="btn-container d-flex justify-content-center align-items-center">
                                            <a href="" class="sam-btn text-white fw-semibold text-decoration-none"><?php echo $lang['lead_to_sam'] ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center justify-content-md-start align-items-center p-0">
                                    <img src="dwtd.png" alt="" class="w-50">
                                </div>
                            </div>
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
</body>
</html>