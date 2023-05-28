
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
</div> 
<h1 class="fw-bold mt-5 mx-3 px-3 info-label">Who is SAM?</h1>
<div class="justify-content-center mx-4 mt-1 p-4">

		<p><?php echo $lang['sam_description']; ?></p>
</div>

<div class="link">    
	<a href="?tnc">Terms and Conditions</a>
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
});
</script>
