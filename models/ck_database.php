<?php

class Database
{
    protected function connect()
    {
        $this->conn = mysqli_connect("localhost", "root", "", "arktechdatabase");

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            return $this->conn;
        }
    }
}
