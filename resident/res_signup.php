<?php
    if(!session_id()) {
        session_start();
    }

    if(isset($_SESSION['status']) && $_SESSION['status'] == 'existing email') {
        echo '<script>
            // Wait for the document to load
            document.addEventListener("DOMContentLoaded", function() {
                // Get the toast element
                var toast = document.querySelector(".toast.existing");
                
                // Show the toast
                toast.classList.add("show");
                
                // Hide the toast after 5 seconds
                setTimeout(function() {
                    toast.classList.remove("show");
                }, 5000);
            });
        </script>';
        unset($_SESSION['status']);
    } else if(isset($_SESSION['status']) && $_SESSION['status'] == 'unmatched password'){
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
        unset($_SESSION['status']);
    } else if(isset($_SESSION['status']) && $_SESSION['status'] == 'invalid age') {
        echo '<script>
            // Wait for the document to load
            document.addEventListener("DOMContentLoaded", function() {
                // Get the toast element
                var toast = document.querySelector(".toast.age");
                
                // Show the toast
                toast.classList.add("show");
                
                // Hide the toast after 5 seconds
                setTimeout(function() {
                    toast.classList.remove("show");
                }, 5000);
            });
        </script>';
        unset($_SESSION['status']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS link -->
    <link rel="stylesheet" href="css/res_signup.css">
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Toast notifications -->
    <div class="toast-container top-0 start-50 translate-middle-x mt-2">
        <div class="toast age text-bg-warning align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex align-items-center">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="material-symbols:warning" class="fs-4 ms-2 me-3"></iconify-icon>
                You must be at least 18 years old to create an account.
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container top-0 start-50 translate-middle-x mt-2">
        <div class="toast existing text-bg-warning align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex align-items-center">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="material-symbols:warning" class="fs-4 ms-2 me-3"></iconify-icon>
                An account with that email already exists. Please try another one.
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container top-0 start-50 translate-middle-x mt-2">
        <div class="toast password text-bg-warning align-items-center py-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex align-items-center">
                <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="material-symbols:warning" class="fs-4 ms-2 me-3"></iconify-icon>
                Passwords do not match
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center p-0">
        <div class="main-container d-flex align-items-center">
            <div class="signup-form row d-flex justify-content-center rounded-4 p-0 m-0">
                <span class="mt-5 d-flex justify-content-center text-center fw-light description">To chat with SAM, you need to make an account first. Fill out</span>
                <span class="d-flex justify-content-center text-center fw-light description">this Sign-up form to get started.</span>
                <h1 class="fw-bold d-flex justify-content-center sam-title mt-2 p-0">SAM</h1>
                <h2 class="fw-semibold d-flex justify-content-center text-center mamamayan-signup mb-3 p-0">Mamamayan Sign-up</h2>
                <div class="col-9 p-0">
                    <form id="signupForm" action="signup_form.php" method="post">
                        <!-- Name field -->
                        <div class="row d-flex justify-content-between">
                            <div class="form-outline col-4 mb-2 ps-0">
                                <label for="f-name" class="f-name-label p-0 m-0">First Name</label>
                                <input type="text" name="f-name" id="f-name" class="form-control border-0 rounded-1" placeholder="First Name" required="required">
                            </div>
                            <div class="form-outline col-4 mb-2 ps-0">
                                <label for="md-name" class="md-name-label p-0">Middle Name</label>
                                <input type="text" name="md-name" id="md-name" class="form-control border-0 rounded-1" placeholder="Middle Name">
                            </div>
                            <div class="form-outline col-4 mb-2 px-0">
                                <label for="last-name" class="last-name-label p-0">Last Name</label>
                                <input type="text" name="l-name" id="l-name" class="form-control border-0 rounded-1" placeholder="Last Name" required="required">
                            </div>
                        </div>
                        <!-- Email field -->
                        <div class="form-outline row mb-4">
                            <label for="email" class="email-label p-0">Email</label>
                            <input type="email" name="email" id="email" class="form-control-md border-0 rounded-1" placeholder="Enter your existing email" required="required">
                        </div>
                        <!-- Birthdate field -->
                        <div class="row d-flex justify-content-between">
                            <label for="b-date" class="b-date-label col-3 mb-2 ps-0">Birthdate</label>
                            <div class="form-outline col-9 mb-2 p-0">
                                <input type="date" name="birthdate" id="birthdate" class="form-control border-0 rounded-1" required="required">
                            </div>
                        </div>
                        <!-- Address field -->
                        <div class="form-outline row mb-2">
                            <label for="address" class="address-label p-0">Address</label>
                            <input type="text" name="address" id="address" class="form-control-md border-0 rounded-1" placeholder="Enter complete address" required="required">
                        </div>
                        <!-- Password field -->
                        <div class="form-outline row mb-2">
                            <label for="password" class="password-label p-0">Password</label>
                            <input type="password" name="password" id="password" class="form-control-md border-0 rounded-1" placeholder="Enter password" autocomplete="off"
                                pattern=.{8,} title="Password must contain 8 or more characters" required>
                        </div>
                        <!-- Password field -->
                        <div class="form-outline row mb-2">
                            <label for="r-password" class="r-password-label p-0">Repeat Password</label>
                            <input type="password" name="rpassword" id="rpassword" class="form-control-md border-0 rounded-1" placeholder="Confirm password" autocomplete="off"
                                pattern=.{8,} title="Password must contain 8 or more characters" required>
                        </div>
                        <!-- Submit button -->
                        <div class="text-center row justify-content-end mb-4">
                            <input type="submit" value="Sign-up" name="sign-up" class="login-button border-0 rounded-3 fw-light text-light p-0">
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="reviewModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <p>Kindly review all the information you have provided.</p>
                                            <div class="col-md-4">
                                                <label for="reviewFirstName">First Name</label>
                                                <p id="reviewFirstName"></p>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="reviewMiddleName">Middle Name</label>
                                                <p id="reviewMiddleName"></p>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="reviewLastName">Last Name</label>
                                                <p id="reviewLastName"></p>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="reviewEmail">Email</label>
                                                <p id="reviewEmail"></p>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="reviewBirthdate">Birthdate</label>
                                                <p id="reviewBirthdate"></p>
                                            </div>
                                            <div class="col-12">
                                                <label for="reviewAddress">Address</label>
                                                <p id="reviewAddress"></p>
                                            </div>
                                        </div>
                                        <p class="fst-italic mb-0 mt-2" style="font-size: 14px;">I hereby certify that all the information provided in this registration form is correct and true.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" id="saveButton" class="btn btn-primary">Sign-up</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="container p-0 mb-3">
                        <span class="fw-light login-account p-0">Already have an account?</span>
                        <a href="./res_login.php" class="text-decoration-none p-0 sign-in">Sign-in</a>
                    </div>
                </div>
                <!-- Button trigger modal -->
                <button type="button" class="btn border-0 mb-5 w-50 tnc" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Terms and Conditions
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Terms and Conditions</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ...
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script>
        $(document).ready(function () {
            // Show the confirmation modal when any form is submitted
            $('#signupForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                const firstName = $('#f-name').val();
                const middleName = $('#md-name').val();
                const lastName = $('#l-name').val();
                const email = $('#email').val();
                const birthdate = $('#birthdate').val();
                const address = $('#address').val();

                // Display the inputted values in the modal
                $('#reviewFirstName').text(firstName);
                $('#reviewMiddleName').text(middleName);
                $('#reviewLastName').text(lastName);
                $('#reviewEmail').text(email);
                $('#reviewBirthdate').text(birthdate);
                $('#reviewAddress').text(address);
                $('#reviewModal').modal('show');
            });

            // Handle the click event of the Save button in the modal
            $('#saveButton').on('click', function() { 
                $('#reviewModal').modal('hide');
                $('#signupForm').off('submit').submit();
            });
        });

    </script>
</body>
</html>
