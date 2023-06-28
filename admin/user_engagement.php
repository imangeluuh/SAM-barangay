<?php 
    // If a session is not already started, start a new session
    if(!session_id()){
        session_start(); 
    } 
    include('../query.php');

    $jsonData = getUserEngagement(); ?>
    <div class="row d-flex mx-4 pt-5">
        <div class="col-md-6">
            <div class="card rounded-3 shadow">
                <div class="card-header d-flex justify-content-center">
                    <h3 class="card-title fw-semibold">User Engagement</h3>
                </div>
                <div class="card-body ">
                    <canvas id="userEngagement" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;" height="500"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card rounded-3 shadow">
                <div class="card-header d-flex justify-content-center">
                    <h3 class="card-title fw-semibold">Question and Request Classification Distribution</h3>
                </div>
                <div class="card-body ">
                    <canvas id="faqsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;" height="500"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php $intentData = getChatbotFaqs(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- ChartJS link -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script>
    $(function () {
        // Interacting User
        const data = <?php echo $jsonData; ?>;
        const chartType = data.labels.length === 1 ? 'bar' : 'line';
        new Chart(document.getElementById("userEngagement"), {
            type: chartType,
            data: {
                labels: data.labels,
                datasets: [{
                    label: "Number of Conversations",
                    data: data.interactingUsers,
                    borderColor: '#ff6384',
                    backgroundColor: '#ff6384',
                    pointStyle: 'circle',
                    pointRadius: 10,
                    pointHoverRadius: 15
                }]
            },
            options: {
                responsive: true,
            }
        });

        const intentData = <?php echo $intentData; ?>;
        new Chart(document.getElementById("faqsChart"), {
            type: "pie",
            data: {
                labels: intentData.labels,
                datasets: [
                    {
                        data: intentData.intentCounts,
                        backgroundColor: ['#ff6384', '#ffcd56', '#4bc0c0', "#059BFF", "#FF9020"]
                    }
                ]
            }, 
        })
    });
</script>
