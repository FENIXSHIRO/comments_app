<?php

namespace App\Models;

use \PDO;

class db
{   
    private $host = '127.0.0.1:3306';
    private $user = 'root';
    private $pass = '12345';
    private $dbname = 'Comments';

    public function connect()
    {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}