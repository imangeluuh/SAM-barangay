<script src="chatbot.js"></script>
<?php
    // Start session 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 
    // Include the database configuration file
    include('../dbconfig.php');
    require_once "../language/" . $_SESSION['lang'] . ".php";

    $current_nav = $_SERVER['PHP_SELF'];
    $current_nav = basename(parse_url($_SERVER['PHP_SELF'], PHP_URL_PATH));
?>
<style>
    .navb.active {
        background-color: transparent!important;
        font-weight: 500;
    }
    .rw-header, .rw-launcher, .rw-client {
        background-color: #053C5E!important;
    }
    .rw-message .rw-avatar {
        width: 40px!important;
        height: 40px;
    }    
    .rw-header .rw-avatar {
        width: 35px!important;
        height: 35px!important;
    }
    .rw-send-icon-ready {
        color: #053C5E!important;
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
                <a class="nav-link navb <?php if ($current_nav == 'res_about_us.php') { echo 'active'; } ?>" aria-current="page" href="res_about_us.php"><?php echo $lang['about_us'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link navb <?php if ($current_nav == 'res_help.php') { echo 'active'; } ?>" aria-current="page" href="res_help.php"><?php echo $lang['help'] ?></a>
            </li>
            <div class="dropdown d-flex align-items-center ms-lg-3 me-lg-4">
                <a href="#" class="p-0 d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="mx-md-2">
                        <p class="d-flex m-0 name"><?php echo $_SESSION['userData']['res_firstname']." ".$_SESSION['userData']['res_lastname']; ?></p>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" id="sign-out" href="?logout=true" id="sign-out" data-bs-toggle="modal" data-bs-target="#exampleModal">Sign out</a></li>
                </ul>
            </div>
        </ul>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p class="fs-semibold">Before you leave.. If you have interacted with our SAM chatbot,  please rate its accuracy on a scale of 1 to 10, with 1 being extremely inaccurate and 10 being highly accurate. Your feedback matters to us. Thank you!</p>
        <form action="signout_form.php" method="post">
        <select name="rate" class="form-select" aria-label="Default select example">
            <option selected disabled>Select a number</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger" id="close-btn" href="signout_form.php">Sign out</a>
        <button type="submit" name="submit" class="btn btn-primary">Submit Rate</button>
        </form>
      </div>
    </div>
  </div>
</div>

