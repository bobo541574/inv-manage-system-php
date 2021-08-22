<?php

class ParentCategory
{
    private $con;

    public function __construct()
    {
        include_once("../database/Database.php");

        $this->con = (new Database)->connect();
    }

    public function getAllParentCategories()
    {
        $stmt = $this->con->prepare(
            "SELECT * FROM parent_categories"
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

    /* Fetch All Parent Category */
    public function getCategoriesWithPagination($current_page)
    {
        $paginate = $this->paginate("parent_categories", "parent_cat_id", $current_page);

        // $sql = "SELECT * FROM Orders LIMIT 10 OFFSET 15";
        $numberOfRecordsPrePage = $paginate["numberOfRecordsPrePage"];
        $skipOfRecords = $paginate["skipOfRecords"];

        $sql = "SELECT * FROM parent_categories LIMIT $numberOfRecordsPrePage OFFSET $skipOfRecords";

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

    /* Add Parent Category */
    public function addParentCategory($parent_category_name)
    {
        $sql = "INSERT INTO `parent_categories` (`parent_cat_name`) VALUES(?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $parent_category_name);
        $result = $stmt->execute() or die($this->con->error);
        if ($result) {
            return "PARENT_CATEGORY_ADDED";
        } else {
            return 0;
        }
    }

    /* Update Parent Category */
    public function updateParentCategory($parent_cat_id, $parent_category_name)
    {
        $sql = "UPDATE `parent_categories` SET `parent_cat_name` = ? WHERE `parent_cat_id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $parent_category_name, $parent_cat_id);
        $result = $stmt->execute() or die($this->con->error);
        if ($result) {
            return "PARENT_CATEGORY_UPDATED";
        } else {
            return 0;
        }
    }

    /* Delete Parent Category */
    public function deleteParentCategory($parent_cat_id)
    {
        $sql = "DELETE FROM `parent_categories` WHERE `parent_cat_id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $parent_cat_id);
        $result = $stmt->execute() or die($this->con->error);

        if ($result) {
            return "PARENT_CATEGORY_DELETED";
        } else {
            return 0;
        }
    }
}