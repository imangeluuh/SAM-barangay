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
    <link rel="stylesheet" href="css/res_dashboard.css">
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

            $stmt = $conn->prepare("CALL SP_COUNT_RES_REQUESTS(?)");
            $stmt->bind_param('s', $_SESSION['userData']['resident_id']);
            // Execute the prepared statement
            $stmt->execute();
            if($stmt) {
                // retrieve the result set from the executed statement
                $result = $stmt->get_result();  
                // fetch the row from the result set
                $row = $result->fetch_assoc();
                $totalPendingRequest = $row['v_pending'];
                $totalInProgressRequest = $row['v_in_progress'];
                $totalCompletedRequest = $row['v_completed'];
            }

            while($conn->next_result()) {
                $conn->store_result();
            }

            $stmt = $conn->prepare("CALL SP_COUNT_RES_REPORTS(?)");
            $stmt->bind_param('s', $_SESSION['userData']['resident_id']);
            // Execute the prepared statement
            $stmt->execute();
            if($stmt) {
                // retrieve the result set from the executed statement
                $result = $stmt->get_result();  
                // fetch the row from the result set
                $row = $result->fetch_assoc();
                $totalPendingReports = $row['v_pending'];
                $totalInProgressReports = $row['v_in_progress'];
                $totalCompletedReports = $row['v_completed'];
            }
        ?>
        <div class="content-wrapper">
            <h3 class="label mx-4 pt-4 ps-2">Dashboard</h3>
            <div class="row d-flex mx-4 pt-3">
                <div class="col-lg-2 col-md-6 d-flex align-items-stretch">
                    <div class="col-12 small-box rounded-3 shadow bg-white">
                        <div class="inner">
                            <h3 class="fw-bold"><?php echo $totalPendingRequest ?></h3>
                            <p>Pending Requests</p>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 d-flex align-items-stretch">
                    <div class=" col-12 small-box rounded-3 shadow bg-white">
                        <div class="inner">
                            <h3 class="fw-bold"><?php echo $totalInProgressRequest ?></h3>
                            <p>In Progress Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6  d-flex align-items-stretch">
                    <div class=" col-12 small-box rounded-3 shadow bg-white">
                        <div class="inner">
                            <h3 class="fw-bold"><?php echo $totalCompletedRequest ?></h3>
                            <p>Completed Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card rounded-3 shadow">
                        <div class="card-header d-flex justify-content-center">
                            <h3 class="card-title fw-semibold">Document Requests</h3>
                        </div>
                        <div class="card-body ">
                            <canvas id="requestChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;" height="500" class="request-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex mx-4 mt-3">
                <div class="col-lg-6">
                    <div class="card rounded-3 shadow p-0">
                        <div class="card-header d-flex justify-content-center">
                            <h3 class="card-title fw-semibold">Concern Reports</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="reportChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;" height="500" class="report-chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 d-flex align-items-stretch">
                    <div class=" col-12 small-box rounded-3 shadow bg-white">
                        <div class="inner">
                            <h3><?php echo $totalPendingReports ?></h3>
                            <p>Pending Reports</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 d-flex align-items-stretch">
                    <div class=" col-12 small-box rounded-3 shadow bg-white">
                        <div class="inner">
                            <h3><?php echo $totalInProgressReports ?></h3>
                            <p>In Progress Reports</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 d-flex align-items-stretch">
                    <div class=" col-12 small-box rounded-3 shadow bg-white">
                        <div class="inner">
                            <h3><?php echo $totalCompletedReports ?></h3>
                            <p>Completed Reports</p>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment"></script>
    <script>
        
    $(function () {
        
        const requestData = {
            labels: ['Pending', 'In Progress', 'Completed'],
            data: [<?= $totalPendingRequest ?>, <?= $totalInProgressRequest ?>,<?= $totalCompletedRequest ?>],
        };

        new Chart(document.getElementById("requestChart"), {
            type: "doughnut",
            data: {
                labels: requestData.labels,
                datasets: [
                    {
                        label: "Document Requests",
                        data: requestData.data,
                        backgroundColor: ['#ff6384', '#ffcd56', '#4bc0c0']
                    }
                ]
            }, 
        })

        const chartData = {
            labels: ['Pending', 'In Progress', 'Completed'],
            data: [<?= $totalPendingReports ?>, <?= $totalInProgressReports ?>,<?= $totalCompletedReports ?>],
        };

        new Chart(document.getElementById("reportChart"), {
            type: "doughnut",
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: "Concern Reports",
                        data: chartData.data,
                        backgroundColor: ['#ff6384', '#ffcd56', '#4bc0c0']
                    }
                ]
            }, 
        })
    })
    </script>
</body>
</html>