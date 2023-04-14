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
    <link rel="stylesheet" href="m_login.css">
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-form rounded-4">
        <div class="row d-flex justify-content-center">
            <h1 class="fw-bold d-flex justify-content-center sam-title mt-5 p-0">SAM</h1>
            <h2 class="fw-semibold d-flex justify-content-center mamamayan-login mb-5 p-0">Mamamayan Login</h2>
            <div class="col-8 p-0">
                <form action="" method="post">
                    <!-- Email field -->
                    <div class="form-outline row mb-3">
                        <input type="text" name="email" id="email" class="form-control-md border-0 rounded-3 border-dark-subtle" placeholder="E-mail" required="required">
                    </div>
                    <!-- Password field -->
                    <div class="form-outline row mb-3">
                        <input type="password" name="password" id="password" class="form-control-md border-0 rounded-3 border-dark-subtle" placeholder="Password" autocomplete="off" required="required">
                    </div>
                    <div class="row">
                        <a href="" class="text-end text-decoration-none forgot-password p-0 mb-3">Forgot Password</a>
                    </div>
                    <!-- Submit button -->
                    <div class="text-center row justify-content-end mb-4">
                        <input type="submit" value="Login" name="login" class="login-button border-0 rounded-3 fw-light text-light p-0">
                    </div>
                </form>
                <div class="container p-0 mb-3">
                    <span class="fw-light create-account  p-0">Don't have an account?</span>
                    <a href="" class="text-decoration-none p-0 sign-up">Sign-up</a>
                </div>
                <div class="container d-flex justify-content-center">
                    <a href="" class="text-decoration-none tnc">Terms and Conditions</a>
                </div>
            </div>
        </div> 
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>