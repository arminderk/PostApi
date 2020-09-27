<?php
require '../bootstrap.php';
use Src\Controller\PostController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// All of the endpoints should start with /posts
// Everything else results in a 404 Not Found
if ($uri[1] !== 'posts') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// Post ID is optional and must be a number
$postID = null;
if (isset($uri[2])) {
    $postID = (int) $uri[2];
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

$postController = new PostController($dbConnection, $requestMethod, $postID);
$postController->processRequest();