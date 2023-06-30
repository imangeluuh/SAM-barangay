<?php include('../dbconfig.php'); ?>
<!-- FAQs -->
<div class="form-group mt-2">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h5>Frequently Asked Questions</h5>
        <!-- Button trigger modal -->
        <div>
            <button type="button" class="btn btn-info border-0" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <span class="add">Add FAQ</span>
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-dark fs-5" id="addModalLabel">Add FAQ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body text-dark">
                <form action="process_faqs.php" method="post">
                    <div class="col-12 mb-3">
                        <label for="question" class="form-label">Question (in English)</label>
                        <input type="text" class="form-control" name="question" id="question" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="answer" class="form-label">Answer (in English)</label>
                        <input type="text" class="form-control" name="answer" id="answer" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="f_question" class="form-label">Question Translation (in Filipino)</label>
                        <input type="text" class="form-control" name="f_question" id="f_question" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="f_answer" class="form-label">Answer Translation (in Filipino)</label>
                        <input type="text" class="form-control" name="f_answer" id="f_answer" required>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="save" value="Save"/>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive mt-3" id="no-more-tables">
        <table id="table1" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $stmt = $conn->prepare("CALL SP_GET_FAQS");
                $stmt->execute();
                if($stmt) {
                    // retrieve the result set from the executed statement
                    $result = $stmt->get_result();  
                    // fetch the row from the result set
                    while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td data-title="Question"><?php echo $row['question']; ?></td>
                                <td data-title="Answer"><?php echo $row['answer']; ?></td>
                                <td data-title="Action">
                                    <div class="d-flex">
                                        <!-- Edit Button trigger modal -->
                                        <button type="button" class="badge-warning border-0 rounded-3 p-1 px-2" data-bs-toggle="modal" data-bs-target="#faq-<?php echo $row['faq_id']; ?>">
                                        Edit
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="faq-<?php echo $row['faq_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body row">
                                                        <form action="process_faqs.php" method="post">
                                                            <div class="col-12 mb-3">
                                                                <label for="faq-id" class="form-label">Faq ID</label><br>
                                                                <input type="hidden" name="faq_id" value="<?php echo $row['faq_id']?>">
                                                                <span><?php echo $row['faq_id']?></span>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="question" class="form-label">Question (in English)</label>
                                                                <input type="text" class="form-control" name="question" id="question" required
                                                                    value="<?php echo $row['question']?>">
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="answer" class="form-label">Answer (in English)</label>
                                                                <input type="text" class="form-control" name="answer" id="answer" required
                                                                    value="<?php echo $row['answer']?>">
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="f_question" class="form-label">Question Translation (in Filipino)</label>
                                                                <input type="text" class="form-control" name="f_question" id="f_question" required
                                                                    value="<?php echo $row['f_question']?>">
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="f_answer" class="form-label">Answer Translation (in Filipino)</label>
                                                                <input type="text" class="form-control" name="f_answer" id="f-answer" required
                                                                    value="<?php echo $row['f_answer']?>">
                                                            </div>
                                                            <div class="col-12">
                                                                <input type="submit" name="edit" value="Save" class="btn btn-primary">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="process_faqs.php" method="post" class="mx-1">
                                            <input type="hidden" name="faq_id" value="<?php echo $row['faq_id']; ?>">
                                            <input type="submit" name="delete"
                                                    class="badge-danger border-0 rounded-3 p-1 px-2" value="Delete" />
                                        </form> 
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } ?>
            </tbody>
        </table>
    </div> 
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS link -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>