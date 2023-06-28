<?php 
    include('../dbconfig.php');
    include('../query.php');
    $stmt = $conn->prepare("CALL SP_GET_AVE_PROCESSING_TIME(?, ?)");
    $stmt->bind_param('ss', $startDate, $endDate);
    // Execute the prepared statement
    $stmt->execute();

    if($stmt) {
        // retrieve the result set from the executed statement
        $result = $stmt->get_result();  

        // fetch the row from the result set
        $row = $result->fetch_assoc();

        $docProcessingTimes = array();
        $reportProcessingTimes = array();
        $labels = array();
        
        foreach ($result as $row) {
        $labels[] = date('F Y', strtotime($row['month']));
        $docProcessingTimes[] = floor($row['doc_ave_process_time'] / 60);
        $reportProcessingTimes[] = floor($row['report_ave_process_time'] / 60);
        }

        // Pass the data to JavaScript
        $aveData = array(
            'labels' => $labels,
            'docAveProcessTime' => $docProcessingTimes,
            'reportAveProcessTime' => $reportProcessingTimes
        );

        // Convert the data to JSON format
        $jsonDataDocAve = json_encode($aveData);
    }
?>
<div class="row d-flex mx-4 pt-5">
    <div class="col-12">
        <div class="card rounded-3 shadow">
            <div class="card-header d-flex justify-content-center">
                <h3 class="card-title fw-semibold">System Analytics</h3>
            </div>
                <div class="row d-flex mx-1 pt-3">
                <div class="col-lg-4 col-md-4 align-items-stretch">
                    <div class="card-body p-0">
                        <div class="col-lg-12 col-md-6 d-flex align-items-stretch">
                            <div class=" col-12 small-box rounded-3 shadow bg-white">
                                <div class="inner">
                                    <div class="d-flex justify-content-center">
                                        <h6 class="fw-semibold mx-3">DOCUMENT REQUEST</h6>
                                        <i class="fa fa-folder-open"></i>
                                    </div>
                                    <h5 class="d-flex justify-content-center pt-3">
                                        <?php
                                        while($conn->next_result()) {
                                            $conn->store_result();
                                        }
                                        $stmt = $conn->prepare("CALL SP_GET_DOC_CUR_PROCESS_TIME");
                                        // Execute the prepared statement
                                        $stmt->execute();
                                        $result = $stmt->get_result();  
                                        $row = $result->fetch_assoc();
                                        $docAveMinutes =  $row['doc_ave_process'];
                                        // Calculate days, hours, minutes
                                        $days = floor($docAveMinutes / (60 * 24));
                                        $remainingMinutes = $docAveMinutes % (60 * 24);
                                        $hours = floor($remainingMinutes / 60);
                                        $minutes = $remainingMinutes % 60;
                                        // Display the average processing time
                                        if ($days > 0) {
                                            echo $days . " day(s), ";
                                        }
                                        if ($hours > 0) {
                                            echo $hours . " hour(s), ";
                                        }
                                        echo $minutes . " minute(s)";
                                        ?>
                                    </h5>
                                    <div class="d-flex justify-content-center">
                                        <p>Average Processing Time</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="col-lg-12 col-md-6 d-flex align-items-stretch">
                            <div class=" col-12 small-box rounded-3 shadow bg-white">
                                <div class="inner">
                                    <div class="d-flex justify-content-center">
                                        <h6 class="fw-semibold mx-3">REPORT CONCERN</h6>
                                        <i class="fa fa-bullhorn"></i>
                                    </div>
                                    <h5 class="d-flex justify-content-center pt-3">
                                        <?php
                                        while($conn->next_result()) {
                                            $conn->store_result();
                                        }
                                        $stmt = $conn->prepare("CALL SP_GET_REPORT_CUR_PROCESS_TIME");
                                        // Execute the prepared statement
                                        $stmt->execute();
                                        $result = $stmt->get_result();  
                                        $row = $result->fetch_assoc();
                                        $reportAveMinutes =  $row['report_ave_process'];
                                        // Calculate days, hours, minutes
                                        $reportDays = floor($reportAveMinutes / (60 * 24));
                                        $reportRemainingMinutes = $reportAveMinutes % (60 * 24);
                                        $reportHours = floor($reportRemainingMinutes / 60);
                                        $reportMinutes = $reportRemainingMinutes % 60;
                                        // Display the average processing time
                                        if ($reportDays > 0) {
                                            echo $reportDays . " day(s), ";
                                        }
                                        if ($reportHours > 0) {
                                            echo $reportHours . " hour(s), ";
                                        }
                                        echo $reportMinutes . " minute(s)";
                                        ?>
                                    </h5>
                                    <div class="d-flex justify-content-center">
                                        <p>Average Processing Time</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="col-lg-12 col-md-6 d-flex align-items-stretch">
                            <div class=" col-12 small-box rounded-3 shadow bg-white">
                                <div class="inner">
                                    <div class="d-flex justify-content-center">
                                        <h6 class="fw-semibold mx-3">CHATBOT RESPONSE</h6>
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    
                                    <h5 class="d-flex justify-content-center pt-3">
                                    <?php
                                        // Call the function to calculate the average response time
                                        $averageResponseTime = calculateAverageResponseTime();
                                        // Display the average response time
                                        echo "$averageResponseTime seconds";
                                    ?>
                                    </h5>
                                    <div class="d-flex justify-content-center">
                                        <p>Average Response Time</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 d-flex align-items-stretch">
                    <div class="col-12 small-box rounded-3 shadow bg-white">
                        <div class="card-header d-flex justify-content-center">
                            <h4 class="card-title fw-semibold">Average Processing and Response Time</h4>
                        </div>
                        <div class="card-body ">
                            <canvas id="docAveChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%; display: block;" height="500" class="doc-ave-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>  
$(function () {
    const aveData = <?php echo $jsonDataDocAve; ?>;
    new Chart(document.getElementById("docAveChart"), {
        type: "bar",
        data: {
            labels: aveData.labels,
            datasets: [
                {
                    label: "Document Request",
                    data: aveData.docAveProcessTime,
                    backgroundColor: "#ffcd56"
                },
                {
                    label: "Report Concern",
                    data: aveData.reportAveProcessTime,
                    backgroundColor: "#ff6384"
                }
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: "top"
            },
            title: {
                display: true,
                text: "Average Processing Time"
            }
        }
    });
})
</script>