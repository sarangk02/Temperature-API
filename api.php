<?php

// Check if the request method is POST and the request has JSON data
// Get the JSON data from the request body
$jsonData = file_get_contents('php://input');

// Decode the JSON data into an associative array
$data = json_decode($jsonData, true);
// $data = json_decode(json_encode(array('lat'=>'32','long'=>'23')), true);


// Check if the required fields exist in the JSON data
if ((isset($data['lat'])) and (isset($data['long']))) {

    $apiUrl = 'https://api.open-meteo.com/v1/forecast';

    // Construct the URL with custom data using query parameters
    $queryParams = http_build_query(array(
        'latitude' => $data['lat'],
        'longitude' => $data['long'],
        'hourly' => 'temperature_2m'
    ));

    $url = $apiUrl . '?' . $queryParams;

    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request
    $response = curl_exec($ch);

    // Close cURL resource
    curl_close($ch);

    // Set the response content type to JSON
    header('Content-Type: application/json');

    echo $response;
} else {
    // Invalid JSON data format
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Invalid JSON data format'));
}
