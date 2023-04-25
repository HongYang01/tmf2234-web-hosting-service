<?php

class DBConnection
{
    private $servername = "localhost";
    private $username = "yourusername";
    private $password = "yourpassword";
    private $dbname = "yourdbname";

    public function getConnection()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}
