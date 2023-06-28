<div class="row mx-4 pt-3">
    <div class="col-md-6">
        <div class="card rounded-3 shadow">
            <div class="card-header d-flex justify-content-center align-items-center py-2">
                <h6 class="fw-semibold my-0 mx-2">Chatbot Speed</h6>
                <iconify-icon icon="fluent-mdl2:chat-bot" class="fs-4"></iconify-icon>
            </div>       
            <div class="card-body pt-2 pb-0">
                <h5 class="d-flex justify-content-center">
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
    <div class="col-md-6">
        <div class="card rounded-3 shadow">
            <div class="card-header d-flex justify-content-center align-items-center py-2">
                <h6 class="fw-semibold my-0 mx-2">Chatbot Accuracy</h6>
                <iconify-icon icon="fluent-mdl2:chat-bot" class="fs-4"></iconify-icon>
            </div>       
            <div class="card-body pt-2 pb-0">
                <h5 class="d-flex justify-content-center">
                <?php
                    echo "97.8%";
                ?>
                </h5>
                <div class="d-flex justify-content-center">
                    <p>Accuracy</p>
                </div>
            </div>
        </div>
    </div>
</div>
