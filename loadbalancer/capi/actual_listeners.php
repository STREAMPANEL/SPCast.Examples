<?php

// Include Configuration
require 'config.php';

// URL of the JSON endpoint
$jsonEndpoint = "https://$loadblancerHostname/capi/actual_listeners.php";

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $jsonEndpoint); // Set the URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // Set timeout in seconds

// Execute cURL session and fetch the JSON data
$jsonData = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    // Decode the JSON data
    $decodedData = json_decode($jsonData, true);

    // Check if decoding was successful
    if ($decodedData === null) {
        echo 'Error decoding JSON';
    } else {
        // Output the total listener count from the JSON data
        echo 'Total Listener Count: ' . $decodedData['total_listener_count'] . "\n";
    }
}

// Close cURL session
curl_close($ch);
