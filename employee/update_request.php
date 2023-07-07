<?php
include('../dbconfig.php');
require "../mail.php";

if(!session_id()){
    session_start(); 
}

$emailBody = "We are pleased to inform you that your recent request for ".$_SESSION['docInfo']['document_type']." has been successfully processed by our Serbisyong Aagapy sa Mamamayan System. 
The requested document is now ready for pickup at your convenience<br><br>
To select a schedule for document pickup, please follow these instructions:<br><br>
1. Visit the Serbisyong Aagapay sa Mamamayan website.<br>
2. Log in to your resident account using your credentials.<br>
3. Navigate to the \"Document Request\" section.<br>
4. Find your processed request for ".$_SESSION['docInfo']['document_type']." and select the option to choose a pickup schedule.<br>
5. Follow the prompts and select your preferred pickup schedule from the available options provided.<br>
6. Submit your choice.<br><br>
Once you have completed the above steps and chosen your pickup schedule, kindly make note of the following details:<br><br>
Pickup Location: Barangay Clearance Department<br><br>
To collect your document, please visit the Barangay Hall located at Commonwealth Ave., cor. Katuparan St., Quezon City on the your preferred pickup schedule.<br><br>
When visiting the Barangay Hall, please remember to bring valid identification or any additional documents mentioned during the request submission process for verification purposes.<br><br>
Thank you for your cooperation and utilizing our Serbisyong Aagapay sa Mamamayan System for your document needs. We appreciate your patience throughout the request process and look forward to serving you.<br><br><br>
<i>Ikinatutuwa naming ipabatid sa iyo na matagumpay na naiproseso ang iyong huling hiling para sa ".$_SESSION['docInfo']['document_type']." gamit ang aming Serbisyong Aagapy sa Mamamayan System. Ang hinihiling na dokumento ay maaaring makuha ayon sa iyong kagustuhan.<br><br>
Upang piliin ang iskedyul para sa pagkuha ng dokumento, sundin lamang ang mga sumusunod:<br><br>
1. Pumunta sa website o portal ng Serbisyong Aagapay sa Mamamayan website.<br>
2. Mag-log in gamit ang iyong residente na account gamit ang iyong mga kredensyal.<br>
3. Pumuntae sa seksyon ng \"Document Request\".<br>
4. Hanapin ang iyong naiprosesong hiling para sa ".$_SESSION['docInfo']['document_type']." at piliin ang opsiyon na pumili ng iskedyul ng pagkuha.<br>
5. Sundin ang mga tagubilin at piliin ang iyong nais na iskedyul ng pagkuha mula sa mga opsyon.<br>
6. Kumpirmahin ang iyong pagpili at isumite ang iyong kahilingan.<br><br>
Kapag natapos mo na ang mga hakbang na nabanggit at napili mo na ang iyong iskedyul ng pagkuha, mangyaring tandaan ang mga sumusunod na detalye:<br><br>
Lugar na Pagkukuhanan: Barangay Clearance Department<br><br>
Para sa pagkuha ng iyong dokumento, mangyaring pumunta sa Barangay Hall na matatagpuan sa Commonwealth Ave., cor. Katuparan St., Quezon City sa nakatakdang iskedyu; ng pagkuha.<br><br>
Kapag pumunta sa Barangay Hall, mangyaring tandaan na dalhin ang valid ID o anumang karagdagang dokumento na nabanggit sa proseso ng pagsusumite ng iyong hiling para sa pagsasaayos.<br><br>
Salamat sa iyong kooperasyon at paggamit ng aming Serbisyong Aagapay sa Mamamayan System para sa iyong mga pangangailangan sa dokumento. Pinahahalagahan namin ang iyong pasensya sa buong proseso ng paghiling at inaasahan naming mapagsilbihan ka nang maayos.</i>";

if(count($_POST)) { 
    // Fetch any remaining result sets
    while($conn->next_result()) {
        $conn->store_result();
    }
    $status = $_POST['status'];
    $stmt = $conn->prepare("CALL SP_UPDATE_STATUS(?, ?, @p_date_completed)");
    // bind the input parameters to the prepared statement
    $stmt->bind_param('is', $_SESSION['docInfo']['request_id'], $status);
    // Execute the prepared statement
    $stmt->execute();
    // Fetch the output parameter value
    $result = $conn->query("SELECT @p_date_completed");
    $row = $result->fetch_assoc();
    $_SESSION['docInfo']['status'] = $status;
    $_SESSION['docInfo']['date_completed'] = $row['@p_date_completed'] == NULL ? 'N/A' : $row['@p_date_completed'];
    
    // update date issude and expiry date
    if($status == 'Ready for pick-up') {
        while($conn->next_result()) {
            $conn->store_result();
        }                    
        $stmt = $conn->prepare("CALL SP_GET_EMAIL(?)");
        // bind the input parameters to the prepared statement
        $stmt->bind_param('s', $_SESSION['docInfo']['resident_id']);
        // Execute the prepared statement
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $email = $row['email'];
        send_mail($email,"Online Document Request (For Releasing)", $GLOBALS['emailBody']);
        
        while($conn->next_result()) {
            $conn->store_result();
        }
        switch($_SESSION['docInfo']['document_type']) {
            case 'Barangay ID':
                $stmt = $conn->prepare("CALL SP_COMPLETE_BRGY_ID(?)");
                break;
            case 'Certificate of Indigency':
                $stmt = $conn->prepare("CALL SP_COMPLETE_COI(?)");
                break;
            case 'Barangay Clearance':
                $stmt = $conn->prepare("CALL SP_COMPLETE_CLEARANCE(?)");
                break;
            case 'Business Permit':
                $stmt = $conn->prepare("CALL SP_COMPLETE_PERMIT(?)");
                break;
        }
        // bind the input parameters to the prepared statement
        $stmt->bind_param('i', $_SESSION['docInfo']['doc_id']);
        // Execute the prepared statement
        $stmt->execute();
    }
    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
    
    header("Location: view_docs.php");
    exit();
}
?>