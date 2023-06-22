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
    <a href="admin_dashboard.php" class="brand-link text-decoration-none d-flex" style="background:#053c5e !important;">
        <img src="../images/brgy-comm.png" class="brand-image img-circle elevation-3" style="opacity: .9">
        <span class="brand-text fs-6">Brgy. Commonwealth</span>
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
                    <a href="configuration_panel.php" class="d-flex nav-link side <?php if ($current_page == 'configuration_panel.php') { echo 'active'; } ?>">
                    <iconify-icon icon="fluent-mdl2:chat-bot" class="me-2" style="font-size: 25px;"></iconify-icon>
                        <p>Chatbot Panel</p>
                    </a>
                </li>
                <li class="nav-item user-panel pt-1">
                    <a href="" class="nav-link side <?php if ($current_page == 'emp_homepage.php') { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-solid fa-circle-info"></i>
                        <p>System Panel</p>
                    </a>
                </li>
                <li class="nav-item user-panel pt-1">
                     <a href="" class="nav-link side">
                        <i class="nav-icon fas fa-solid fa-chart-simple"></i>
                        <p>Reports</p>
                    </a>
                </li>
                <li class="nav-item user-panel pt-1">
                    <a href="admin_feedbacks.php" class="nav-link side <?php if ($current_page == 'admin_reports.php') { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-solid fa-comment"></i>
                        <p>Feedback</p>
                    </a>
                </li>                
            </ul>
        </nav>
    </div>
</aside>

<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>