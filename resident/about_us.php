<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS link -->
    <link rel="stylesheet" href="about_us.css">
    <!-- Google Fonts API link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
	<div>
    <h1 class="fw-bold mt-3 p-3">Citizen's Charter</h1>
		<div class="justify-content-center mt-1 p-4">
			<table>
			<tr>
				<th>Services</th>
				<th>Requirements</th>
				<th>Steps to Follow</th>
				<th>Fees</th>
				<th>Processing Time</th>
				<th>Responsible Person</th>
			</tr>
			<tbody>
		            <?php 
						$conn = new mysqli("localhost", "root", "", "sam_barangay");
						if($conn->connect_error){
							die('Failed to connect : '.$conn->connect_error);
						} else {
							$stmt = $conn->prepare("select service_name, req, steps, fees, time, person from c_charter");
							$stmt->execute();
							$stmt_result = $stmt->get_result();
						}
					
					if(!empty($stmt_result)){		            	
		            	// loop in stmt{		            		 
		            	while( $row = $stmt_result->fetch_array(MYSQLI_NUM))  {
		            ?>
		            <tr>		                
		                <td><?php echo $row[0]; ?></td>
		                <td><?php echo $row[1]; ?></td>
		                <td><?php echo $row[2]; ?></td>
						<td><?php echo $row[3]; ?></td>
		                <td><?php echo $row[4]; ?></td>
		                <td><?php echo $row[5]; ?></td>		 		                
		            </tr>
		            <?php 
		        			} 
		        		}else{ ?>
		            		<tr><td colspan="7">No detail(s) found...</td></tr>
		            	<?php } ?>
		    </tbody>
			</table>
		</div> 
	</div>

    <h1 class="fw-bold mt-3 p-3">Who is SAM?</h1>
		<div class="justify-content-center mt-1 p-4">
                <?php 
						$stmt2 = $conn->prepare("select details from system_details where detail_id=1");
						$stmt2->execute();
						$stmt_result2 = $stmt2->get_result(); 
                        $row = $stmt_result2->fetch_array(MYSQLI_NUM)
		        ?>
                        <p><?php echo $row[0]; ?></p>
         </div>
	
	<div class="link">    
  		<a href="t_and_c.php">Terms and Conditions</a>
	</div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>