<?php

class Database
{
    public function connect()
    {
        include_once("constants.php");
        $con = new mysqli(HOST, USER, PASS, DB);
        if ($con) {
            return $con;
        }
        return "Database connection is failed!!!";
    }
}



// $db = new Database();
// $db->connect();