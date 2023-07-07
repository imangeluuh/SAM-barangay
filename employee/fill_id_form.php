<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF Fill PDF Form Results</title>
</head>
<body>

<?php 

if(!session_id()) {
    session_start();
}



// Get submitted form data
$apiKey = "majosej199@lukaat.com_e3823718f89b2e7358b55582dfd3c7559a75e0aeb01a7c365badff541bd206977a14c0bc"; // The authentication key (API Key). Get your own by registering at https://app.pdf.co

// Prepare URL for Fill PDF API call
$url = "https://api.pdf.co/v1/pdf/edit/add";

// Prepare requests params
// See documentation: https://apidocs.pdf.co
$parameters = array();

// Direct URL of source PDF file.
$parameters["url"] = "https://drive.google.com/file/d/1OAe89XhRg5OABQo6zJh_wwON4dft5LwV/view?usp=sharing";

// Name of resulting file
$parameters["name"] = "bryg-id-form-". $_SESSION['brgy-id']['id'];

// If large input document, process in async mode by passing true
$parameters["async"] = false;

$lastName = strtoupper($_SESSION['brgy-id']['lastName']);
$firstName = strtoupper($_SESSION['brgy-id']['firstName']);
$middleInitial = strtoupper($_SESSION['brgy-id']['middleInitial']);
$address = strtoupper($_SESSION['brgy-id']['address']);
$birthdate = date_create($_SESSION['brgy-id']['birthdate']);
$birthplace = strtoupper($_SESSION['brgy-id']['birthplace']);
$contactName = strtoupper($_SESSION['brgy-id']['contactName']);
$contactAddress = strtoupper($_SESSION['brgy-id']['contactAddress']);
$dateIssued = date_create($_SESSION['brgy-id']['dateIssued']);
$expiryDate = date_create($_SESSION['brgy-id']['expiryDate']);
// Field Strings
$fields =   '[{
    "fieldName": "Text-HX4lEbxRZ4",
    "pages": "0",
    "text": "'.$lastName.'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Text-er9RoJIGfC",
    "pages": "0",
    "text": "'.$firstName.'",
    "fontName": "Courier",
    "size": 7
},
{
    "fieldName": "Text-zYqk6XPJco",
    "pages": "0",
    "text": "'.$middleInitial.'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Paragraph-vUWAQwbG9W",
    "pages": "0",
    "text": "'.$address.'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Text-0SQPK50jew",
    "pages": "0",
    "text": "'.date_format($birthdate, 'n-j-y').'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Text-O_W2Fp5hHC",
    "pages": "0",
    "text": "'.$birthplace.'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Text-JrxZKRKYfz",
    "pages": "0",
    "text": "'.$_SESSION['brgy-id']['precinctNo'].'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Text-P-cqQ4bwxV",
    "pages": "0",
    "text": "'.$_SESSION['brgy-id']['id'].'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Text-NdaGpvrDOl",
    "pages": "1",
    "text": "'.$contactName.'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Text-zwlY0tDcJY",
    "pages": "1",
    "text": "'.$contactAddress.'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Text-4aQiU4kH6k",
    "pages": "1",
    "text": "'.$_SESSION['brgy-id']['contactNo'].'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Date-hRGX_GrAYD",
    "pages": "1",
    "text": "'.date_format($dateIssued, 'n-j-y').'",
    "fontName": "Courier",
    "size": 8
},
{
    "fieldName": "Date-WAgv9RUPrg",
    "pages": "1",
    "text": "'.date_format($expiryDate, 'n-j-y').'",
    "fontName": "Courier",
    "size": 8
}]';// JSON string

// Convert JSON string to Array
$fieldsArray = json_decode($fields, true);

$parameters["fields"] = $fieldsArray;

// Create Json payload
$data = json_encode($parameters);

// Create request
$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPHEADER, array("x-api-key: " . $apiKey, "Content-type: application/json"));
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

// Execute request
$result = curl_exec($curl);

if (curl_errno($curl) == 0)
{
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if ($status_code == 200)
    {
        $json = json_decode($result, true);
        
        if (!isset($json["error"]) || $json["error"] == false)
        {
            $resultFileUrl = $json["url"];
            
            // Display link to the file with conversion results
            header('Location: '.$resultFileUrl);
        }
        else
        {
            // Display service reported error
            echo "<p>Error: " . $json["message"] . "</p>"; 
        }
    }
    else
    {
        // Display request error
        echo "<p>Status code: " . $status_code . "</p>"; 
        echo "<p>" . $result . "</p>";
    }
}
else
{
    // Display CURL error
    echo "Error: " . curl_error($curl);
}

// Cleanup
curl_close($curl);

?>

</body>
</html>

            