<?php

class DBConnection
{
    private $servername = "";
    private $username = "";
    private $password = "";
    private $dbname = "";

    public function getConnection()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "success";
        }

        return $conn;
    }
}
