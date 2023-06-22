<?php
function displaySchedulePicker() { ?>
    <div class="col-12 mt-4">
        <span class="fw-semibold">Appointment Information</span>
    </div>
    <!-- Datepicker -->
    <div class="col-md-6">
        <input type="text" class="form-control schedule" id="datepicker" name="datepicker" disabled required="required" autocomplete="off"
            value="<?php if(!empty($_SESSION['docInfo']['schedule'])) {echo $_SESSION['docInfo']['schedule'];}?>">
        <div class="row option mt-4 d-none">
            <div class="col-md-6">
                <input type="radio" name="time" value="08:00:00"><label class="ms-1 fw-semibold">8:00AM - 9:00AM</label>
            </div>
            <div class="col-md-6">
                <input type="radio" name="time" value="09:00:00"><label class="ms-1 fw-semibold">9:00AM - 10:00AM</label>
            </div>
            <div class="col-md-6">
                <input type="radio" name="time" value="10:00:00"><label class="ms-1 fw-semibold">10:00AM - 11:00AM</label>
            </div>
            <div class="col-md-6">
                <input type="radio" name="time" value="11:00:00"><label class="ms-1 fw-semibold">11:00AM - 12:00PM</label>
            </div>
            <div class="col-md-6">
                <input type="radio" name="time" value="13:00:00"><label class="ms-1 fw-semibold">1:00PM - 2:00PM</label>
            </div>
            <div class="col-md-6">
                <input type="radio" name="time" value="14:00:00"><label class="ms-1 fw-semibold">2:00PM - 3:00PM</label>
            </div>
            <div class="col-md-6">
                <input type="radio" name="time" value="15:00:00"><label class="ms-1 fw-semibold">3:00PM - 4:00PM</label>
            </div>
            <div class="col-md-6">
                <input type="radio" name="time" value="16:00:00"><label class="ms-1 fw-semibold">4:00PM - 5:00PM</label>
            </div>
        </div>
    </div>  
<?php }
?>