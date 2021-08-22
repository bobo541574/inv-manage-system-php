<?php

class Category
{

    private $con;

    public function __construct()
    {
        include_once("../database/Database.php");

        $this->con = (new Database)->connect();
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
        $sql = "SELECT `cat_id`, `category_name` FROM `categories`";
        $stmt = $this->con->prepare($sql);
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

    private function paginate($table, $toCount, $current_page)
    {
        $paginate = [];
        $numberOfRecordsPrePage = 10;
        $sql =  "SELECT COUNT($toCount) as results FROM $table";
        $query = $this->con->query($sql);
        $numberOfRecords = mysqli_fetch_assoc($query);
        $totalPages = ceil($numberOfRecords["results"] / $numberOfRecordsPrePage);
        $skipOfRecords = ($current_page == 1 ? 0 : $numberOfRecordsPrePage * ($current_page - 1));
        $paginate = [
            "numberOfRecordsPrePage" => $numberOfRecordsPrePage,
            "numberOfRecords" => $numberOfRecords,
            "totalPages" => $totalPages,
            "skipOfRecords" => $skipOfRecords,
            "prev_page" => $current_page - 1,
            "next_page" => $current_page + 1
        ];

        return $paginate;
    }

    public function getCategoriesWithPagination($current_page)
    {
        $paginate = $this->paginate("categories", "cat_id", $current_page);

        // $sql = "SELECT * FROM Orders LIMIT 10 OFFSET 15";
        $numberOfRecordsPrePage = $paginate["numberOfRecordsPrePage"];
        $skipOfRecords = $paginate["skipOfRecords"];

        $sql = "SELECT *, p_cats.parent_cat_name 
            FROM categories as cats 
            JOIN parent_categories as p_cats 
            ON cats.parent_cat_id = p_cats.parent_cat_id LIMIT $numberOfRecordsPrePage OFFSET $skipOfRecords";

        $stmt = $this->con->prepare($sql);
        $stmt->execute() or die($this->con->error);
        $result = $stmt->get_result();
        $paginatedRecords = [];
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $paginatedRecords = [
                "paginate" => $paginate,
                "rows" => $rows
            ];

            return $paginatedRecords;
        }

        return "NO_DATA";
    }

    public function updateCategory($category_id, $parent_cat_id, $category_name)
    {
        $sql = "UPDATE categories SET `parent_cat_id` = ?, `category_name` = ? WHERE `cat_id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("isi", $parent_cat_id, $category_name, $category_id);
        $result = $stmt->execute() or die($this->con->error);

        if ($result) {
            return "CATEGORY_UPDATED";
        } else {
            return 0;
        }
    }

    public function statusCategory($category_id, $category_status)
    {
        $category_status = $category_status ? 0 : 1;
        $sql = "UPDATE categories SET `status` = ? WHERE `cat_id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $category_status, $category_id);
        $result = $stmt->execute() or die($this->con->error);

        if ($result) {
            return "CATEGORY_STATUS";
        } else {
            return 0;
        }
    }

    public function deleteCategory($category_id)
    {
        $sql = "DELETE FROM categories WHERE `cat_id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $result = $stmt->execute() or die($this->con->error);

        if ($result) {
            return "CATEGORY_DELETED";
        } else {
            return 0;
        }
    }
}

// $cat = new Category();
// echo json_encode($cat->getAllCategories());
// echo "<pre>";
// print_r($cat->getAllCategories());
// echo "</pre>";