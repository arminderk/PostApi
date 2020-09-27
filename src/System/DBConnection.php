<?php
namespace Src\System;

use PDO;
use PDOException;

class DBConnection {
    private $dbConnection = null;

    public function __construct() {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $db = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        
        try {
            $this->dbConnection = new PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $username,
                $password
            );
        }
        catch(PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection() {
        return $this->dbConnection;
    }
}