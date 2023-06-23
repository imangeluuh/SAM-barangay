<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mamamayan Home Page</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS link -->
    <link rel="stylesheet" href="css/res_language.css">
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        // If a session is not already started, start a new session
        if(!session_id()){
            session_start(); 
        } 

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: ../index.php");
            exit;
        }

        if(array_key_exists('en_button', $_POST)) {
            $_SESSION['lang'] = 'en';
        }
        else if(array_key_exists('fil_button', $_POST)) {
            $_SESSION['lang'] = 'fil';
        } 

        if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
            session_start();
            session_destroy();
            header("Location: ../index.php");
            exit();
        }
    ?>
    <div class="main-container overflow-hidden">
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container-fluid">
                <div class="logo"> <h1 class=""> <a href="#" class="my-link">SAM</a></h1> </div>
                <button class="navbar-toggler border-0 text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-dark navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end pe-5" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item mx-2">
                            <a class="nav-link fs-5" href="?logout=true">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content row d-flex">
            <div class="row d-flex justify-content-center">
                <div class="col-md-4 d-flex flex-column justify-content-center p-0">
                    <p class="preferred">Before we get started, What is your <br> preferred language?</p>
                    <p class="fst-italic preferred">Bago tayo magsimula, ano ang wika <br> na nais mong gamitin? </p>
                    <form action="../language/lang_config.php" method="post">
                        <div class="d-flex flex-column align-items-center">
                            <input type="submit" name="en_button" value="English"class="button">
                            <input type="submit" name="fil_button" value="Filipino" class="button">
                        </div>
                    </form>
                </div>
                <div class="col-md-3 d-flex justify-content-center justify-content-md-start align-items-center p-0">
                    <img src="../images/SAM CHATBOT.png" alt="" class="justify-content-sm-center sam-img">
                </div>
            </div>
            <!-- Button trigger modal -->
            <button type="button" class="btn border-0 mb-5 text-center mt-5 fs-5 text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Terms and Conditions
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Terms and Conditions</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- pop up modal -->
                        <div class="modal-body">
                        <p class="pt-3">Welcome to <b>Serbisyong Aagapay sa Mamamayan (SAM)</b>!</p>
                        <p class="tab">These Terms and Conditions ("Agreement") govern your use of Serbisyong Aagapay sa Mamamayan (SAM), including the features, services, and chatbot provided by the system. By accessing or using Serbisyong Aagapay sa Mamamayan (SAM), you agree to be bound by these Terms and Conditions.</p><br>
                        <p><b>SECTION A: GENERAL TERMS</b></p><br>
                        <p><b>1. Registration</b><br>
                            <ul class="list-unstyled">
                                <li class="ms-3">1.1 By registering an account on the Serbisyong Aagapay sa Mamamayan (SAM), you agree to provide accurate, complete, and up-to-date information during the registration process.</li>
                                <li class="ms-3">1.2 You are solely responsible for maintaining the confidentiality of your account information, including your email and password. You are responsible for all activities that occur under your account.</li>
                            </ul>
                        </p>
                        <p><b>2. User Conduct</b>
                            <ul class="list-unstyled">
                                <li class="ms-3">2.1 You agree to use the Barangay System in compliance with all applicable laws and regulations.</li>
                                <li class="ms-3">2.2 You shall not engage in any activities that may disrupt or interfere with the functioning of the Serbisyong Aagapay sa Mamamayan (SAM) or compromise its security.</li>
                            </ul>
                        </p><br>
                        <p><b>SECTION B: TECHNOLOGY</b></p><br>
                        <p><b>1. System Availability</b>
                            <ul class="list-unstyled">
                                <li class="ms-3">1.1 Serbisyong Aagapay sa Mamamayan (SAM) strives to provide uninterrupted access to its features and services. However, there may be instances of temporary unavailability due to maintenance, upgrades, or unforeseen technical issues.</li>
                                <li class="ms-3">1.2 The authorities will make reasonable efforts to notify users in advance of any scheduled maintenance or upgrades that may result in temporary unavailability of the system.</li>
                            </ul>
                        </p>
                        <p><b>SECTION C: DATA USAGE, PRIVACY, AND SECURITY</b></p><br>
                        <p><b>1. Data Collection and Usage</b>
                            <ul class="list-unstyled">
                                <li class="ms-3">1.1 By using Serbisyong Aagapay sa Mamamayan (SAM), you acknowledge and agree that the authorities may collect and process your personal information in accordance with applicable data protection laws.</li>
                                <li class="ms-3">1.2 The authorities may use your personal information for the purpose of document processing, concern resolution, system improvement, and other related activities.</li>
                            </ul>
                        </p><br>
                        <p><b>SECTION D: ADDITIONAL LEGAL TERMS</b></p><br>
                        <p><b>1. Modifications and Termination</b>
                            <ul class="list-unstyled">
                                <li class="ms-3">1.1 The authorities reserve the right to modify, suspend, or terminate Serbisyong Aagapay sa Mamamayan (SAM) or any part thereof at any time without prior notice.</li>
                                <li class="ms-3">1.2 The authorities may also update or modify these Terms and Conditions. It is your responsibility to review this Agreement periodically for any changes.</li>
                            </ul>
                        </p><br>
                        <p class="tab">By using Serbisyong Aagapay sa Mamamayan (SAM), you agree to comply with these Terms and Conditions.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>
</html> 