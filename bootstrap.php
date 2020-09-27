<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;
use Src\System\DBConnection;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $dbConnection = (new DBConnection())->getConnection();