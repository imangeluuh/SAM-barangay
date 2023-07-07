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
$parameters["url"] = "https://drive.google.com/file/d/1wer20Duv_Dq0KFLzunpLoetmQVUtR3_Q/view?usp=sharing";

// Name of resulting file
$parameters["name"] = "business-permit-form-". $_SESSION['permit']['id'];

// If large input document, process in async mode by passing true
$parameters["async"] = false;

$expiryDate = date_create($_SESSION['permit']['expiry_date']);
$name = strtoupper($_SESSION['permit']['name']);
$address = strtoupper($_SESSION['permit']['address']);
$businessName = strtoupper($_SESSION['permit']['business-name']);
// Field Strings
$fields =   '[{
    "fieldName": "Text-65sCcd-cut",
    "pages": "0",
    "text": "'.$name.'",
    "fontName": "Arial",
    "size": 12
},
{
    "fieldName": "Text-aexqfLIsZO",
    "pages": "0",
    "text": "'.$businessName.'",
    "fontName": "Arial",
    "size": 12
},
{
    "fieldName": "Text-df05HTzLMV",
    "pages": "0",
    "text": "'.$address.'",
    "fontName": "Arial",
    "size": 12
},
{
    "fieldName": "Date-jP7JSd74HJ",
    "pages": "0",
    "text": "'.date_format($expiryDate, "F d, Y").'",
    "fontName": "Arial",
    "size": 12
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

            