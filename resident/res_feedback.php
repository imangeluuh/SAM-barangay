<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serbisyong Aagapay sa Mamamayan</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- AdminLTE CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- CSS link -->
    <link rel="stylesheet" href="../resident/css/res_feedback.css">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap JS link -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed hold-transition overflow-x-hidden">
	<div class="wrapper">
		<?php 
        if(!session_id()){
            session_start(); 
        } 
        
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: ../index.php");
            exit;
        }

            include('navbar.php');
            include('sidebar.php');
        ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row p-0 ms-md-3 me-md-5 pe-md-5">

                        <?php 
                            if(isset($_POST['submit'])) {
                                $question_1 = $_POST['question_1'];
                                $question_2 = $_POST['question_2'];
                                $question_3 = $_POST['question_3'];
                                $question_4 = $_POST['question_4'];
                                $question_5 = $_POST['question_5'];
                                $question_6 = $_POST['question_6'];
                                $question_7 = $_POST['question_7'];
                                $question_8 = $_POST['question_8'];
                                $question_9 = $_POST['question_9'];
                                $question_10 = $_POST['question_10'];
                                $suggestions = $_POST['suggestions'];

                                $stmt = $conn->prepare("CALL SP_ADD_FEEDBACK(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                $stmt->bind_param('sssssssssss', $question_1, $question_2, $question_3, $question_4, $question_5, $question_6, $question_7, $question_8, $question_9, $question_10, $suggestions);
                                
                                if ($stmt->execute()){

                                    echo "<script>alert('Thank you for taking the time to complete our feedback form. Your input is greatly appreciated and will help us improve our services. We value your opinion and are grateful for your valuable feedback.'); window.location.href = 'res_feedback.php';</script>";
                                    exit(); 
                                }

                                else {
                                    echo "<script>alert('Failed to submit feedback.'); window.location.href = 'res_feedback.php';</script>";
                                    exit();
                                }
                            }
                            ?>

                        <div class="col-lg-12 mt-5">
                            <h1 class="fw-bold change-label">Feedback Form</h1>
                            <div class="m-0 p-0">
                                <p class="desc">Do you have suggestions or found some issues in using SAM Barangay System? Let us know below.</p>
                            </div>
                            <div class="row p-0 ms-md-3 me-md-5 pe-md-5">
                                <div class="row p-0 ms-md-3 me-md-5 pe-md-5">
                                    <div class="row p-0 ms-md-3 me-md-5 pe-md-5">
                                        <form action="" method="post" class="pt-5 pe-md-5 me-md-5">
                                            <!-- 1st Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question1">1. Did the chatbot understand your questions and respond accurately?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_1" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_1" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 2nd Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">2. Did the chatbot engage in a natural and conversational manner?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_2" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_2" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 3rd Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">3. Was it easy to navigate and find the necessary features or functions of the system?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_3" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_3" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 4th Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">4. Were there any confusing or unclear elements in the user interface?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_4" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_4" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 5th Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">5. Was the user interface (UI) of the system visually appealing and well-designed?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_5" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_5" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 6th Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">6. Were you able to easily submit document requests through the system?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_6" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_6" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 7th Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">7. Were you able to easily obtain your requested document through the system?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_7" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_7" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 8th Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">8. Were you able to easily address and report your concerns through the system?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_8" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_8" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 9th Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">9. Were your reported concerns easily resolved through the system?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_9" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_9" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 10th Question -->
                                            <div class="row questiongrp">
                                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="question2">10. Would you recommend using this system to others?</label>
                                                        <div class="agile_info_select">
                                                            <div><input type="radio" name="question_10" value="Yes" id="yes" required> 
                                                                <label class="rb-label" for="Yes">Yes</label>
                                                                <div class="check w3"></div>
                                                            </div>
                                                            <div><input type="radio" name="question_10" value="No" id="no"> 
                                                                <label class="rb-label" for="no">No</label>
                                                                <div class="check w3ls"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="suggestions" class="form-label">Suggestions, narrative of system issues or problem you encountered, etc.</label>
                                                <input type="text" class="form-control" name="suggestions" id="suggestions" placeholder="Describe your issue or idea...">
                                            </div>
                                            <!-- Submit button -->
                                            <div class="field-div text-center d-flex pe-md-5 me-md-5 mt-2 p-3">
                                                <input type="submit" value="Submit Feedback" name="submit" class="submit-button border-0 rounded-3 fw-light text-light p-0 px-2 me-md-4">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
	
	 <!-- AdminLTE JS link -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
