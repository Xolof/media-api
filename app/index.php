<?php
/**
* Get data from the Instagram Basic Display API.
* Reference: https://developers.facebook.com/docs/instagram-basic-display-api/guides/getting-profiles-and-media
* Olof Johansson
* Updated: 2021-03-21
*/

// Turn on or off error reporting.
error_reporting(0);
// error_reporting(E_ALL);

// Import the allowed origin.
$allowedOrigin = trim(file_get_contents("../config/allowed-origin.txt"));

// Allow from specified origin.
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: $allowedOrigin");
}

// Import the access token.
$accessToken = trim(file_get_contents("../config/long-lived-token.txt"));

// The API URL without query params.
$baseUrl = "https://graph.instagram.com/me/media";

// The data fields to request.
// Reference: https://developers.facebook.com/docs/instagram-basic-display-api/reference/media#fields
// NOTE: Can't find any field about likes. Perhaps this field is only available in the Instagram Graph API.
$fields = [
    "id",
    "caption",
    "media_type",
    "media_url",
    "permalink",
    "thumbnail_url",
    "timestamp",
    "username"
];

// Construct the URL.
$url = $baseUrl . "?fields=" . implode(",", $fields) . "&access_token=" . $accessToken;

// Try to make a cURL request.
try {
    // Initialize a new session and return a cURL handle
    // for use with the curl_setopt(), curl_exec(), and curl_close() functions.
    $curlRequest = curl_init($url);

    // Set CURLOPT_RETURNTRANSFER to true.
    // Return the transfer as a string of the return value of curl_exec()
    // instead of outputting it directly.
    curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL session.
    $json = curl_exec($curlRequest);

    if ($json === false) {
        // If it fails, throw an exception.
        throw new Exception(curl_error($curlRequest), curl_errno($curlRequest));
    }

    // Close the cURL session.
    curl_close($curlRequest);
} catch (Exception $e) {
    // Print exception.
    trigger_error(
        sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(),
            $e->getMessage()
        ),
        E_USER_ERROR
    );
}

// Set header to send response as JSON.
header("Content-Type: application/json");

// Send response.
echo $json;
