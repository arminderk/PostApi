<?php
require '../bootstrap.php';

$clientId = $_ENV['OKTACLIENTID'];
$clientSecret = $_ENV['OKTASECRET'];
$issuer = $_ENV['OKTAISSUER'];
$scope = $_ENV['SCOPE'];

// Get an access token
$token = obtainToken($issuer, $clientId, $clientSecret, $scope);

// test requests
getAllPosts($token);
getPost($token, 1);

// Function to retrieve an access token from Okta
function obtainToken($issuer, $clientId, $clientSecret, $scope) {
    echo "Obtaining token...";

    // prepare the request
    $uri = $issuer . '/v1/token';
    $token = base64_encode("$clientId:$clientSecret");
    $payload = http_build_query([
        'grant_type' => 'client_credentials',
        'scope'      => $scope
    ]);

    // build the curl request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        "Authorization: Basic $token"
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // process and return the response
    $response = curl_exec($ch);
    $response = json_decode($response, true);
    if (! isset($response['access_token'])
        || ! isset($response['token_type'])) {
        exit('failed, exiting.');
    }

    echo "success!\n";
    // Token to use in API requests
    return $response['token_type'] . " " . $response['access_token'];
}

function getAllPosts($token) {
    echo "Getting all posts...";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/posts");
    curl_setopt( $ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        "Authorization: $token"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    var_dump($response);
}

function getPost($token, $id) {
    echo "Getting post with id: $id...";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/posts/" . $id);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        "Authorization: $token"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    var_dump($response);
}