<?php

class ParentCategory
{
    private $con;

    public function __construct()
    {
        include_once("../database/Database.php");

        $db = new Database();
        $this->con = $db->connect();
    }

    public function getAllCategories()
    {
        $stmt = $this->con->prepare("SELECT * FROM parent_categories");
        $stmt->execute() or die($this->con->error);
        $result = $stmt->get_result();
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }

        return "NO_DATA";
    }
}