<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS link -->
    <link rel="stylesheet" href="css/emp_login.css">
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
            $email = $_POST['work-email'];
            $password = $_POST['password'];

            // Hash the password using bcrypt algorithm
            $hash = password_hash($password, PASSWORD_BCRYPT);

            // Call the stored procedure
            $stmt = $conn->prepare("CALL SP_FIND_LOGIN(?)");

            // bind the input parameters to the prepared statement
            $stmt->bind_param('s', $email);

            // Execute the prepared statement
            $stmt->execute();

            // retrieve the result set from the executed statement
            $result = $stmt->get_result();  

            // fetch the row from the result set
            $row = $result->fetch_assoc();

            // If no rows are returned, display an error message
            $rowcount = mysqli_num_rows($result);

            if(!$rowcount || $row['role_id'] != 2) {
                echo "<script>alert('The email you entered isn\'t connected to an account.')</script>";
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
                    $stmt = $conn->prepare("CALL SP_GET_EMP_INFO(?)");

                    // bind the input parameters to the prepared statement
                    $stmt->bind_param('s', $email);

                    // Execute the prepared statement
                    $stmt->execute();

                    // retrieve the result set from the executed statement
                    $result = $stmt->get_result();  

                    // fetch the row from the result set
                    $row = $result->fetch_assoc();

                    $userData += array('employee_id' => $row['employee_id']
                                        , 'emp_firstname' => $row['emp_firstname']
                                        , 'emp_lastname' => $row['emp_lastname']);

                    $_SESSION['userData'] = $userData;
                    $_SESSION['loggedin'] = true;
                    header("Location: ./emp_homepage.php");
                    exit();
                } else {
                    echo "<script>alert('The password you\'ve entered is incorrect.')</script>";
                }
            }
            $stmt->close();
            $conn->close();

        }
    ?>
    <div class="container-fluid d-flex justify-content-center align-items-center p-0">
        <div class="main-container d-flex align-items-center">
            <div class="login-form bg-light row d-flex justify-content-center rounded-4 p-0 m-0">
                <h1 class="fw-bold d-flex justify-content-center sam-title mt-5 p-0">SAM</h1>
                <h2 class="fw-semibold d-flex justify-content-center admin-login mb-5 p-0">Employee Login</h2>
                <div class="col-7 p-0">
                    <form action="" method="post">
                        <!-- Work Email field -->
                        <div class="form-outline row mb-3">
                            <label for="email" class="email-label p-0">Work Email</label>
                            <input type="email" name="work-email" id="work-email" class="form-control-md rounded-3 border-dark-subtle" placeholder="Enter your work email" required="required">
                        </div>
                        <!-- Password field -->
                        <div class="form-outline row mb-3">
                            <label for="password" class="password-label p-0">Password</label>
                            <input type="password" name="password" id="password" class="form-control-md rounded-3 border-dark-subtle" placeholder="Enter your password" autocomplete="off" required="required">
                        </div>
                        <!-- Submit button -->
                        <div class="text-center row justify-content-end mb-5">
                            <input type="submit" value="Login" name="login" class="login-button border-0 rounded-3 fw-light text-light p-0">
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>
