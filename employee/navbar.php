<?php
    // Start session 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 
    // Include the database configuration file
    include('../dbconfig.php');

    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        session_start();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }

    $current_nav = $_SERVER['PHP_SELF'];
    $current_nav = basename(parse_url($_SERVER['PHP_SELF'], PHP_URL_PATH));
?>

<style>
    .navb.active {
        background-color: none!important;
        font-weight: 500;
    }
    .role {
        font-size: 14px;
    }
</style>

<nav class="main-header navbar navbar-expand-md border-0 navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item ps-3">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link navb <?php if ($current_nav == 'emp_about_us.php') { echo 'active'; } ?>" aria-current="page" href="emp_about_us.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navb <?php if ($current_nav == 'emp_help.php') { echo 'active'; } ?>" aria-current="page" href="emp_help.php">Help</a>
            </li>
            <div class="dropdown d-flex align-items-center ms-lg-3 me-lg-4">
                <a href="#" class="p-0 d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="mx-md-2">
                        <p class="d-flex m-0 name"><?php echo $_SESSION['userData']['emp_firstname']." ".$_SESSION['userData']['emp_lastname']; ?></p>
                        <p class="d-flex justify-content-end fst-italic m-0 role">Barangay Employee</p>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?logout=true">Sign out</a></li>
                </ul>
            </div>
        </ul>
    </div>
</nav>
