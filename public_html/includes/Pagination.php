<?php


class Pagination
{
    private $con;
    public function __construct()
    {
        include_once("../database/Database.php");
        include_once("Category.php");

        $this->con = (new Database)->connect();
    }

    public function pagination()
    {
        $result = new Category();
    }
}