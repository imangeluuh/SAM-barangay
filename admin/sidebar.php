<?php
    $current_page = $_SERVER['PHP_SELF'];
    $current_page = basename(parse_url($_SERVER['PHP_SELF'], PHP_URL_PATH));
?>

<style>
    .side.active {
        background-color: #144e73!important;
        color: #ffffff!important;
    }

    .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
    }

</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4 shadow" style="background:#053c5e !important;">
    <a href="emp_homepage.php" class="brand-link text-decoration-none" style="background:#053c5e !important;">
        <img src="../images/SAM.png"  class="brand-image img-circle elevation-3" style="opacity: .9">
        <span class="brand-text">Talk to SAM now!</span>
    </a>

    <div class="sidebar">
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-white fw-light" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item user-panel pt-1">
                    <a href="admin_dashboard.php" class="nav-link side <?php if ($current_page == 'admin_dashboard.php') { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item user-panel pt-1">
                    <a href="admin_accounts.php" class="nav-link side <?php if ($current_page == 'admin_accounts.php') { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-sharp fa-solid fa-users"></i>
                        <p>Accounts</p>
                    </a>
                </li>
                <li class="nav-item user-panel pt-1">
                    <a href="" class="d-flex nav-link side <?php if ($current_page == 'emp_homepage.php') { echo 'active'; } ?>">
                        <span class="nav-icon material-symbols-outlined me-2" style="font-size:25px;">smart_toy</span>
                        <p>Chatbot</p>
                    </a>
                </li>
                <li class="nav-item user-panel pt-1">
                    <a href="" class="nav-link side <?php if ($current_page == 'emp_homepage.php') { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-solid fa-chart-simple"></i>
                        <p>Reports</p>
                    </a>
                </li>
                <li class="nav-item user-panel pt-1">
                    <a href="" class="nav-link side <?php if ($current_page == 'emp_homepage.php') { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-solid fa-circle-info"></i>
                        <p>Information</p>
                    </a>
                </li>
                
            </ul>
        </nav>
    </div>
</aside>
