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
    <link rel="stylesheet" href="css/admin_style.css">
    <!-- AdminLTE CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- DataTable CSS link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                header("Location: admin_login.php");
                exit;
            }

            include('navbar.php');
            include('sidebar.php');

            $stmt = $conn->prepare("CALL SP_COUNT_FEEDBACK_ANSWERS");
            // Execute the prepared statement
            $stmt->execute();

            if($stmt) {
                // retrieve the result set from the executed statement
                $result = $stmt->get_result();  

                // fetch the row from the result set
                $row = $result->fetch_assoc();

            }

            while($conn->next_result()) {
                $conn->store_result();
            }
        ?>
        <div class="content-wrapper mt-0 pt-5">
        <div class="wrapper p-5 mt-3">
            <div class="card shadow">
                <div class="card-header request-header">
                    <span class="fs-4 history">Resident's Feedback</span>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive mt-3" id="no-more-tables">
                        <table id="doc_req" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Yes</th>
                                    <th>No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-title="Question">Did the chatbot understand resident's questions and respond accurately?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Did the chatbot engage in a natural and conversational manner?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Was it easy to navigate and find the necessary features or functions of the system?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Were there any confusing or unclear elements in the user interface?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Was the user interface (UI) of the system visually appealing and well-designed?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Were the residents able to easily submit document requests through the system?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Were the residents able to easily obtain documents through the system?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Were the residents able to easily address and report concerns through the system?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Were the residents' reported concerns easily resolved through the system?</td>
                                    <td data-title="Yes"><?php echo $row['q1_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q1_no'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Question">Would the residents recommend using this system to others?</td>
                                    <td data-title="Yes"><?php echo $row['q10_yes'].'%'?></td>
                                    <td data-title="No"><?php echo $row['q10_no'].'%'?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="content-wrapper mt-0">
            <h3 class="label mx-4 pt-2 ps-2">Residents' Suggestions, Issues Encountered, etc.</h3>
            <div class="row d-flex mx-4 pt-3">
                <?php
                    $stmt = $conn->prepare("CALL SP_GET_SUGGESTIONS");
                    // Execute the prepared statement
                    $stmt->execute();
                    if($stmt) {
                            // retrieve the result set from the executed statement
                            $result = $stmt->get_result();  
                            // fetch the row from the result set
                            while($row = $result->fetch_assoc()) { 
                                if($row['suggestions'] != '') {?>
                                <div>
                                    <div class="card rounded-3 shadow">
                                        <div class="card-header rounded-3 suggestion">
                                            <h5 class="card-title"><?php echo $row['suggestions'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                        <?php   }
                            } 
                    }?>
            </div>
        </div>
    </div>

    
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- AdminLTE JS link -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- DataTables JS link -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>
