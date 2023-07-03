<h1 class="fw-bold mx-3 p-3 info-label">Citizen's Charter</h1>
<div class="c-charter justify-content-center m-0 table-responsive" id="no-more-tables">
	<?php 
		require_once "../language/" . $_SESSION['lang'] . ".php";
		include('../dbconfig.php');
		
		if($conn->connect_error){
			die('Failed to connect : '.$conn->connect_error);
		} else {
			$stmt = $conn->prepare("CALL SP_GET_CCHARTER");
			$stmt->execute();
			$result = $stmt->get_result();
		}
	?>
	<div id="carouselExample" class="carousel slide mx-5">
		<div class="carousel-inner">
			<?php
				$isFirst = true;	            	            		 
				while($row = $result->fetch_assoc())  {
				if($isFirst) {
			?>
			<div class="carousel-item active">
				<img src="https://drive.google.com/uc?export=view&id=<?php echo $row['image'] ?>" class="carousel-image d-block w-100" alt="...">
			</div>
			<?php } else { ?>
				<div class="carousel-item">
					<img src="https://drive.google.com/uc?export=view&id=<?php echo $row['image'] ?>" class="carousel-image d-block w-100" alt="...">
				</div>
			<?php } $isFirst = false;
			}
			?>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
	<!-- // popup modal -->
	<div class="modal fade" id="enlargedModal" tabindex="-1" role="dialog" aria-labelledby="enlargedModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-body">
				<img src="" class="enlarged-image w-100" alt="Enlarged Image">
			</div>
			</div>
		</div>
	</div>
<?php
	while($conn->next_result()) {
		$conn->store_result();
	}
	$stmt = $conn->prepare("CALL SP_GET_SYSTEM_DETAILS(?, @p_1, @p_2, @p_3, @p_4)");
	$stmt->bind_param("s", $lang['details']);
	$stmt->execute();
	// Fetch the output parameter value
    $result = $conn->query("SELECT @p_1, @p_2, @p_3, @p_4");
    $row = $result->fetch_assoc();

	// Store the OUT parameter values in variables
	$p1 = $row['@p_1'];
	$p2 = $row['@p_2'];
	$p3 = $row['@p_3'];
	$p4 = $row['@p_4'];

	// Close the database connection
	$conn->close();
	?>
	<h1 class="fw-bold mx-5 p-4 info-label">About SAM</h1>
	<div class="row d-flex mx-5">
    	<div class="col-12">
			<div class="card rounded-3 shadow">
				<div class="row d-flex mx-2 pt-3">
					<div class="col-lg-8 col-md-4 pt-3 align-items-stretch">
						<h2 class="fw-bold mx-4 p-0">Serbisyong Aagapay sa Mamamayan (SAM)</h2>
						<h4 class="card-title mx-4 p-0"><?php echo $p4 ?></h4>
						<button class="blue-button" data-toggle="modal" data-target="#myModal"><?php echo $lang['read'] ?></button>
						<!-- Modal -->
						<div id="myModal" class="about_us_modal">
							<div class="modal_content">
								<span class="close">&times;</span>
								<p><?php echo $p1 ?></p>
								<p><?php echo $p2 ?></p>
								<p><?php echo $p3 ?></p>
							</div>
						</div>
						<p class = "mx-4 pt-4"><?php echo $lang['socmed'] ?></p>
						<div class="social-icons mx-4 p-0">
							<a href="#" target="_blank" style="color: #053c5e;"><i class="fab fa-facebook-messenger fa-lg m-1"></i></a>
							<a href="#" target="_blank" style="color: #053c5e;"><i class="fab fa-facebook fa-lg m-1"></i></a>
							<a href="#" target="_blank" style="color: #053c5e;"><i class="fab fa-youtube fa-lg m-1"></i></a>
						</div>
					</div>
					<div class="col-lg-4 col-md-8 d-flex align-items-stretch">
						<div class="card-body">
							<img src="../images/SAM CHATBOT.png" width="300" height="300">
						</div>
					</div>
				</div>
			</div>
    	</div>
    </div>
</div>
<div class="row justify-content-center">    
	<!-- Button trigger modal -->
	<button type="button" class="btn border-0 mb-5" data-bs-toggle="modal" data-bs-target="#tncModal">
	Terms and Conditions
	</button>
	<!-- Modal -->
	<div class="modal fade" id="tncModal" tabindex="-1" aria-labelledby="tncModalLabel" aria-hidden="true">
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


<script>
$(document).ready(function() {
	const myCarouselElement = document.querySelector('#carouselExample')

	const carousel = new bootstrap.Carousel(myCarouselElement, {
		interval: 2000,
		touch: false
	})

    $('.carousel-image').on('click', function(){
    	var imgSrc = $(this).attr('src');
    	$('.enlarged-image').attr('src', imgSrc);
    	$('#enlargedModal').modal('show');
    });
	// Open modal when the button is clicked
	document.querySelector(".blue-button").addEventListener("click", function() {
    	document.getElementById("myModal").style.display = "block";
 	 });

  // Close modal when the close button or outside the modal is clicked
	document.querySelector(".close").addEventListener("click", function() {
		document.getElementById("myModal").style.display = "none";
	});

	window.addEventListener("click", function(event) {
		var modal = document.getElementById("myModal");
		if (event.target == modal) {
		modal.style.display = "none";
		}
	});
});
</script>
