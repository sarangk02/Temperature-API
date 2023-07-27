<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $urlParts = explode('/', $urlPath);
    $lat = intval($urlParts[3]);
    $long = intval($urlParts[4]);

    if ($lat and $long) {


        $apiUrl = 'https://api.open-meteo.com/v1/forecast';

        // Construct the URL with custom data using query parameters
        $queryParams = http_build_query(array(
            'latitude' => $lat,
            'longitude' => $long,
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
    }
}
