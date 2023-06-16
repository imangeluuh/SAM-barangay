<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbisyong Aagapay sa Mamayan</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                <div class="container-fluid p-0">
                    <div class="row mb-5 mx-5">
                        <div class="col-sm-6 p-0">
                            <div class="d-flex justify-content-center justify-content-lg-end pe-md-5">
                                <div class="talk-bubble tri-right border btm-left-in">
                                    <div class="talktext text-center">
                                        <p>I can help you!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center justify-content-lg-end pe-sm-5 pe-lg-5">
                                <img src="../images/SAM CHATBOT.png" alt="" class="sam-img">
                            </div>
                        </div>
                        <div class="col-sm-6 d-flex flex-column justify-content-center align-items-center align-items-lg-start p-0">
                            <p class="sam mt-5 mb-0">SAM</p>
                            <div class="p-0">
                                <p class="sam-subtitle text-center text-lg-left fw-semibold w-md-75">Serbisyong Aagapay sa Mamamayan</p>
                                <!-- <p class="sam-subtitle text-center text-lg-left fw-semibold">sa Mamamayan</p> -->
                            </div>
                            <div class="services-btn d-flex justify-content-center align-items-center m-2">
                                <a href="res_doc_req.php" class="text-light services">Request a Document</a>
                            </div>
                            <div class="services-btn d-flex justify-content-center align-items-center m-2">
                                <a href="res_concern_report.php" class="text-light services">Request a Concern</a>
                            </div>
                        </div>
                    </div>
                    <div class="row second-container m-0 pb-5">
                        <p class="fw-bold sam-subtitle text-center mt-3 mb-0">What we offer</p>
                        <p class="blue-text text-center mt-0 mb-4">Document Request</p>
                        <div class="row px-5">
                            <div class="col-lg-3 col-md-6 d-flex flex-column justify-content-center align-items-center docu-col py-5">
                                <p class="label text-center m-0">Barangay</p>
                                <p class="label text-center m-0">ID</p>
                                <img src="../images/brgy-id.svg" alt="" class="docu-img my-2">
                            </div>
                            <div class="col-lg-3 col-md-6 d-flex flex-column justify-content-center align-items-center docu-col py-5">
                                <p class="label text-center m-0">Certificate of</p>
                                <p class="label text-center m-0">Indigency</p>
                                <img src="../images/cert-ind.svg" alt="" class="docu-img">
                            </div>
                            <div class="col-lg-3 col-md-6 d-flex flex-column justify-content-center align-items-center docu-col py-5">
                                <p class="label text-center m-0">Barangay</p>
                                <p class="label text-center m-0">Clearance</p>
                                <img src="../images/clearance.svg" alt="" class="docu-img">
                            </div>
                            <div class="col-lg-3 col-md-6 d-flex flex-column justify-content-center align-items-center last docu-col py-5">
                                <p class="label text-center m-0">Business</p>
                                <p class="label text-center m-0">Permit</p>
                                <img src="../images/permit.svg" alt="" class="docu-img">
                            </div>
                        </div>
                    </div>
                    <div class="row mx-3 px-md-5 mx-md-5 pt-5">
                        <p class="blue-text">Concern Report</p>
                        <div class="col-md-6">
                            <ul class="fs-5">
                                <li>Loud Neighbor</li>
                                <li>Abusive Barangay Employee</li>
                                <li>Noisy Karaoke</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="fs-5">
                                <li>Thief</li>
                                <li>Pusher</li>
                                <li>And many others</li>
                            </ul>
                        </div>
                    </div>
                    <hr class="mt-5 mb-2">
                    <div class="row mx-3 px-md-5 mx-md-5 pb-2">
                        <div class="col d-flex align-items-center justify-content-end">
                            <span class="me-4">Our Social Media Sites:</span>
                            <iconify-icon icon="ic:baseline-facebook" style="color: #053c5e;" class="mx-1 fs-4"></iconify-icon>
                            <iconify-icon icon="ri:messenger-fill" style="color: #053c5e;" class="mx-1 fs-4"></iconify-icon>
                            <iconify-icon icon="ri:youtube-fill" style="color: #053c5e;" class="mx-1 fs-4"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- AdminLTE JS link -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- IconifyIcon JS link -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
</html>