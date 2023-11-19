<?php

// Include Configuration
require 'config.php';

// URL of the JSON endpoint
$jsonEndpoint = "https://$loadblancerHostname/capi/station_history.php";

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $jsonEndpoint); // Set the URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); // Set timeout in seconds

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
        // Output the data in a table format
        echo '<table border="1">';
        echo '<tr><th>Date</th>';
        echo '<th>Song</th></tr>';

        foreach ($decodedData as $item) {
            $timestamp = date('Y-m-d H:i:s', $item['timestamp']);
            echo '<tr><td>' . $timestamp . '</td>';
            echo '<td>' . $item['metadata']['song'] . '</td></tr>';
        }

        echo '</table>';
    }
}

// Close cURL session
curl_close($ch);
