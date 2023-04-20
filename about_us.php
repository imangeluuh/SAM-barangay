<div class="about-us row mb-md-4 mx-md-4">	
	<h1 class="fw-bold mt-3 p-3">Citizen's Charter</h1>
	<div class="c-charter justify-content-center m-0 table-responsive" id="no-more-tables">
		<table class="table">
			<thead>
				<tr>
					<th>Services</th>
					<th>Requirements</th>
					<th>Steps to Follow</th>
					<th>Fees</th>
					<th>Processing Time</th>
					<th>Responsible Person</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					include('../dbconfig.php');
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
				<tr scope="row">		                
					<td data-title="Services"><?php echo $row[1]; ?></td>
					<td data-title="Requirements"><?php echo $row[2]; ?></td>
					<td data-title="Steps to Follow"><?php echo $row[0]; ?></td>
					<td data-title="Fees"><?php echo $row[3]; ?></td>
					<td data-title="Processing Time"><?php echo $row[4]; ?></td>
					<td data-title="Responsible Person"><?php echo $row[5]; ?></td>		 		                
				</tr>
				<?php 
						} 
					}else{ ?>
						<tr scope="row"><td colspan="7">No detail(s) found...</td></tr>
					<?php } ?>
			</tbody>
		</table>
	</div> 
	<h1 class="fw-bold mt-3 px-3">Who is SAM?</h1>
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
		<a href="?tnc">Terms and Conditions</a>
	</div>
</div>