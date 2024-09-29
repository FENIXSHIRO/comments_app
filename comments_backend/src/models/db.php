<?php

namespace App\Models;

use PDO;

class db
{
    private $host;
    private $dbname;
    private $user;
    private $pass;
    private $conn;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->host = $config['host'];
        $this->dbname = $config['dbname'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
    }

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception('Database connection error: ' . $e->getMessage());
        }
        return $this->conn;
    }
}
