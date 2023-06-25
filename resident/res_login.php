<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS link -->
    <link rel="stylesheet" href="css/res_login.css">
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // Start session 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 

    // Include the database configuration file
    include('../dbconfig.php');

    // Check if the login form has been submitted
    if(isset($_POST['login'])){
        // Get the input data
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Hash the password using bcrypt algorithm
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Call the stored procedure to retrieve user login information from the database
        $stmt = $conn->prepare("CALL SP_FIND_LOGIN(?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('s', $email);
        // Execute the prepared statement
        $stmt->execute();
        // retrieve the result set from the executed statement
        $result = $stmt->get_result();  
        // fetch the row from the result set
        $row = $result->fetch_assoc();
        // Execute the prepared statement
        $rowcount = mysqli_num_rows($result);

        // If no rows are returned, display an error message
        if(!$rowcount || $row['role_id'] != 3) {
            echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.email");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
        } else {
            // If a row is returned, verify the password entered by the user with the hashed password stored in the database
            if(password_verify($password, $row['password'])) {
                // If the password is correct, create an array containing the user's email and hashed password
                $userData = array('email' => $row['email']
                                    , 'password' => $row['password']);

                // Fetch any remaining result sets
                while($conn->next_result()) {
                    $conn->store_result();
                }

                // Call the stored procedure to retrieve user information from the database
                $stmt = $conn->prepare("CALL SP_GET_RES_INFO(?)");
                // bind the input parameters to the prepared statement
                $stmt->bind_param('s', $email);
                // Execute the prepared statement
                $stmt->execute();
                // retrieve the result set from the executed statement
                $result = $stmt->get_result();  
                // fetch the row from the result set
                $row = $result->fetch_assoc();

                $userData += ['resident_id' => $row['resident_id']
                                , 'res_firstname' => $row['res_firstname']
                                , 'res_middlename' => $row['res_middlename']
                                , 'res_lastname' => $row['res_lastname']
                                , 'birthdate' => $row['birthdate']
                                , 'address' => $row['address']];

                // Store the user data array in the $_SESSION variable for future use.
                $_SESSION['userData'] = $userData;
                $_SESSION['loggedin'] = true;

                // redirect the user to 'res_language.php'
                header("Location: ./res_language.php");
                exit();
            } else { 
                // <!-- If the password is incorrect, display an error message -->
                echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.password");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
            }
        }

        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    }

    if(isset($_GET['success']) && $_GET['success'] == true) {
        echo '<script>
                        // Wait for the document to load
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the toast element
                            var toast = document.querySelector(".toast.created");
                            
                            // Show the toast
                            toast.classList.add("show");
                            
                            // Hide the toast after 5 seconds
                            setTimeout(function() {
                                toast.classList.remove("show");
                            }, 5000);
                        });
                    </script>';
    }

    ?>
    <!-- Toast notifications -->
    <div class="toast-container top-0 start-50 translate-middle-x mt-2">
        <div class="toast password text-bg-danger align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex align-items-centera">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="material-symbols:error" class="fs-4 ms-2 me-3"></iconify-icon>
                The password you've entered is incorrect.
                </div>
                <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container top-0 start-50 translate-middle-x mt-2">
        <div class="toast email text-bg-info align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex align-items-center">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="mdi:information" class="fs-4 ms-2 me-3"></iconify-icon>
                The email you've entered isn't connected to an account.
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container top-0 start-50 translate-middle-x mt-2">
        <div class="toast created text-bg-success align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex align-items-centera">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="mdi:success-bold" class="fs-4 ms-2 me-3"></iconify-icon>
                Your account has been created successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center p-0">
        <div class="main-container d-flex align-items-center">
            <div class="login-form row d-flex justify-content-center rounded-4 p-0 m-0">
                <h1 class="fw-bold d-flex justify-content-center sam-title mt-5 p-0">SAM</h1>
                <h2 class="fw-semibold d-flex justify-content-center text-center mamamayan-login mb-5 p-0">Mamamayan Login</h2>
                <div class="col-8 p-0">
                    <form action="" method="post">
                        <!-- Email field -->
                        <div class="form-outline row mb-3">
                            <label for="email" class="email-label p-0">Email</label>
                            <input type="text" name="email" id="email" class="form-control-md border-0 rounded-3 border-dark-subtle" placeholder="Enter your email address" required="required">
                        </div>
                        <!-- Password field -->
                        <div class="form-outline row mb-3">
                            <label for="password" class="password-label p-0">Password</label>
                            <input type="password" name="password" id="password" class="form-control-md border-0 rounded-3 border-dark-subtle" placeholder="Enter your password" autocomplete="off"
                                pattern=.{8,} title="Password must contain 8 or more characters" required=>
                        </div>
                        <div class="row justify-content-end mb-3">
                            <div class="col-auto">
                                <a href="forgot_pass.php" class="text-decoration-none forgot-password p-0 mb-3">Forgot Password</a>
                            </div>
                        </div>
                        <!-- Submit button -->
                        <div class="text-center row justify-content-end mb-4">
                            <input type="submit" value="Login" name="login" class="login-button border-0 rounded-3 fw-light text-light p-0">
                        </div>
                    </form>
                    <div class="container p-0 mb-3">
                        <span class="fw-light create-account  p-0">Don't have an account?</span>
                        <a href="./res_signup.php" class="text-decoration-none p-0 sign-up">Sign-up</a>
                    </div>
                    
                </div>
                <!-- Button trigger modal -->
                <button type="button" class="btn border-0 mb-5 w-50 tnc" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
    </div>
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
</html>
