<h1 class="fw-bold mt-5 p-3">Terms and Conditions</h1>
<div class="justify-content-center mt-1 p-4">
    <?php 
        $conn = new mysqli("localhost", "root", "", "sam_barangay");
        $stmt2 = $conn->prepare("select details from system_details where detail_id=2");
        $stmt2->execute();
        $stmt_result2 = $stmt2->get_result(); 
        $row = $stmt_result2->fetch_array(MYSQLI_NUM)
    ?>
    <p><?php echo $row[0]; ?></p>
</div>