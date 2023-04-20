<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mamamayan Home Page</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS link -->
    <link rel="stylesheet" href="css/res_language.css">
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-container overflow-hidden">
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container-fluid">
                <div class="logo"> <h1 class=""> <a href="#" class="my-link">SAM</a></h1> </div>
                <button class="navbar-toggler border-0 text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-dark navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end pe-5" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <!-- <li class="nav-item mx-2">
                            <a class="nav-link fs-5" aria-current="page" href="#">About Us</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link fs-5" href="#">Help</a>
                        </li> -->
                        <li class="nav-item mx-2">
                            <a class="nav-link fs-5" href="#">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content row d-flex">
            <div class="col-md-6 d-flex flex-column justify-content-center alignt-items-center align-items-md-end pe-md-4">
                <div class="d-flex flex-column align-items center">
                    <p>Before we get started, What is your <br> preffered language?</p>
                    <p class="fst-italic">Bago tayo magsimula, ano ang wika <br> na nais mong gamitin? </p>
                    <div class="d-flex flex-column align-items-center">
                        <a href="res_homepage.php">
                          <button class="button">English</button>
                        </a>
                        
                        <a href="res_homepage.php"> 
                          <button class="button">Filipino</button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 justify-content-center justify-content-md-start align-items-center">
                <img src="../samsuit.png" alt="" class="w-50">
            </div>
            <a href="#" class="text-decoration-none text-center mt-5 fs-5 text-dark">Terms and Conditions</a>
        </div>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>
</html> 