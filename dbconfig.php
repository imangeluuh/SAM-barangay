<?php

    $conn = mysqli_connect('localhost', 'root', '', 'sam_barangay');

    if (!$conn) {
        die(mysqli_error($conn));
    } 
?>