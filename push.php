<?php
// Replace with real server API key from Google APIs
$apiKey = "AIzaSyBNocSKnUTtFo4UD-LYQKb3XxAhuhTIVUU";

// Replace with real client registration IDs
$registrationIDs = array(
"APA91bG7enqKABfClk0SDyjlETi4MWvobXsF7JJ8NZCrVWfFgEBOcrnfUXBciVM_rJCtWhUDNP8r7HHeZ8tlESLp1SAh5jtkGXHCE_pYtLs9JiwzYjrzU4sLvbXsqZJt1ITQ_aZUvJZgtU64GUEF9sOH9_SCn1LMYsLZHXwqT3M57BqaapO-4g0");

// Message to be sent
$message = "Ceci est un test";

// Set POST variables
$url = 'https://android.googleapis.com/gcm/send';

$fields = array(
'registration_ids' => $registrationIDs,
'data' => array( "message" => $message ),
);

$headers = array(
'Authorization: key=' . $apiKey,
'Content-Type: application/json'
);

// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields ));

// Execute post
$result = curl_exec($ch);

// Close connection
curl_close($ch);
echo $result;
//print_r($result);
//var_dump($result);
?>