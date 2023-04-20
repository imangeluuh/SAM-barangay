<!-- CSS link -->
<link rel="stylesheet" href="css/navbar.css">

<?php

    // Start session 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 

    // Include the database configuration file
    include('../dbconfig.php');

    // Include the database configuration file
    include('../dbconfig.php');

?>

<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between d-md-none d-block">
            <button class="btn open-btn px-1 py-0 me-2"><i class="fas fa-regular fa-bars"></i></button>
            <a class="navbar-brand" href="#"><span class="sam-title fw-bold fs-1 px-2 py-0">SAM</span></a>
        </div>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-semibold" aria-current="page" href="res_about_us.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="#">Help</a>
                </li>
                <div class="dropdown d-flex align-items-center ms-lg-3 me-lg-4">
                    <a href="#" class="p-0 d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- <img src="./sam.png" alt="" width="50" height="50" class="rounded-circle d-none d-md-inline "> -->
                        <span class="mx-md-2">
                            <p class="d-flex fw-bold m-0 name"><?php echo $_SESSION['userData']['res_firstname']." ".$_SESSION['userData']['res_lastname']; ?></p>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../index.php">Sign out</a></li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(".nav-item .nav-link").on('click', function(){
        $(".nav-item .nav-link.active").removeClass('active');
        $(this).addClass('active');
    });
</script>