<?php


class Pagination
{
    private $con;
    public function __construct()
    {
        include_once("../database/Database.php");
        include_once("Category.php");

        $db = new Database();
        $this->con = $db->connect();
    }

    public function pagination()
    {
        $result = new Category();
    }
}