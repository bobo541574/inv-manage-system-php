<?php

class Category
{

    private $con;

    public function __construct()
    {
        include_once("../database/Database.php");

        $db = new Database();
        $this->con = $db->connect();
    }

    public function addCategory($parent_cat_id, $category_name)
    {
        $stmt = $this->con->prepare("INSERT INTO `categories` (`parent_cat_id`, `category_name`, `status`) 
                                    VALUES(?, ?, ?)");
        $status = 1;
        $stmt->bind_param("isi", $parent_cat_id, $category_name, $status);
        $result = $stmt->execute() or die($this->con->error);
        if ($result) {
            return "CATEGORY_ADDED";
        } else {
            return 0;
        }
    }

    public function getAllCategories()
    {
        $stmt = $this->con->prepare(
            "SELECT *, p_cats.parent_cat_name 
            FROM categories as cats 
            JOIN parent_categories as p_cats 
            ON cats.parent_cat_id = p_cats.parent_cat_id"
        );
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

// $cat = new Category();
// echo "<pre>";
// print_r($cat->getAllCategories());
// echo "</pre>";