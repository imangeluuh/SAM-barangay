<?php
    include('../dbconfig.php');

    // Get the selected date
    $date = $_POST['date'];

    $stmt = $conn->prepare("CALL SP_COUNT_SLOT(?)");
    // bind the input parameters to the prepared statement
    $stmt->bind_param('s', $date);
    // Execute the prepared statement
    $stmt->execute(); 

    $result = $stmt->get_result();

    // Loop through the results and create an array of availability for each time slot
    $availability = array();
    while ($row = $result->fetch_assoc()) {
      $time = $row['time'];
      $slot = $row['slot'];
      $availability[$time] = $slot; 
    }

    header('Content-Type: application/json');
    // Return the availability as a JSON object
    echo json_encode($availability);
?>