        <?php 
            // If a session is not already started, start a new session
            if(!session_id()){
                session_start(); 
            } 

            include('navbar.php');
            include('sidebar.php');

            $stmt = $conn->prepare("CALL SP_COUNT_FEEDBACK_ANSWERS");
            // Execute the prepared statement
            $stmt->execute();
            if($stmt) {
                // retrieve the result set from the executed statement
                $result = $stmt->get_result();  
                // fetch the row from the result set
                $row = $result->fetch_assoc();
            }
            while($conn->next_result()) {
                $conn->store_result();
            }
        ?>
        <div class="row mx-4 pt-3 px-2">
            <div class="card rounded-3 shadow">
                <div class="card-header request-header">
                    <span class="fs-4 history">Resident's Feedback</span>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive mt-3" id="no-more-tables">
                        <table id="doc_req" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-title="Category">Chatbot understand resident's questions and responds accurately</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">Chatbot engages in a natural and conversational manner</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">Easy to navigate and find the necessary features or functions of the system</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">Confusing or unclear elements in the user interface</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">The user interface (UI) of the system is visually appealing and well-designed</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">Residents were able to easily submit document requests through the system</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">Residents were able to easily obtain documents through the system</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">Residents were able to easily address and report concerns through the system</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">Residents' reported concerns were easily resolved through the system</td>
                                    <td data-title="Percentage"><?php echo $row['q1_yes'].'%'?></td>
                                </tr>
                                <tr>
                                    <td data-title="Category">Residents would recommend using this system to others</td>
                                    <td data-title="Percentage"><?php echo $row['q10_yes'].'%'?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-4 pt-3 px-2">
            <h3 class="label p-0 pt-2">Residents' Suggestions, Issues Encountered, etc.</h3>
            <div class="row ps-2 pt-3">
                <?php
                    $stmt = $conn->prepare("CALL SP_GET_SUGGESTIONS");
                    // Execute the prepared statement
                    $stmt->execute();
                    if($stmt) {
                            // retrieve the result set from the executed statement
                            $result = $stmt->get_result();  
                            // fetch the row from the result set
                            while($row = $result->fetch_assoc()) { 
                                if($row['suggestions'] != '') {?>
                                <div class="p-0">
                                    <div class="card rounded-3 shadow">
                                        <div class="card-header rounded-3 suggestion">
                                            <h5 class="card-title"><?php echo $row['suggestions'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                        <?php   }
                            } 
                    }?>
            </div>
        </div>
    <!-- DataTables JS link -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>
