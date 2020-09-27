<?php

class Order
{
    private $con;
    public function __construct()
    {
        include_once("../database/Database.php");
        $db = new Database();
        $this->con = $db->connect();
    }

    public function addOrder()
    {
    }
}