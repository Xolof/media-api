<?php
// error_reporting(0);
error_reporting(E_ALL);

$accessToken = file_get_contents("./secret/long-lived-token.txt");

$accessToken = trim($accessToken);

$url = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username&access_token=$accessToken";

try {
    $curlRequest = curl_init();

    curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curlRequest, CURLOPT_URL, $url);

    $json = curl_exec($curlRequest);

    if ($json === false) {
        // TODO: Print some error message
        throw new Exception(curl_error($curlRequest), curl_errno($curlRequest));
    }

    curl_close($curlRequest);
} catch (Exception $e) {
    trigger_error(
        sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(),
            $e->getMessage()
        ),
        E_USER_ERROR
    );
}

header('Content-Type: application/json');

echo $json;
