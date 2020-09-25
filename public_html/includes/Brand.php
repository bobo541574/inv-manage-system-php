<?php

class Brand
{
    private $con;

    public function __construct()
    {
        include_once("../database/Database.php");

        $db = new Database();
        $this->con = $db->connect();
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

    /* Fetch All Brand */
    public function getCategoriesWithPagination($current_page)
    {
        $paginate = $this->paginate("brands", "brand_id", $current_page);

        // $sql = "SELECT * FROM Orders LIMIT 10 OFFSET 15";
        $numberOfRecordsPrePage = $paginate["numberOfRecordsPrePage"];
        $skipOfRecords = $paginate["skipOfRecords"];

        $sql = "SELECT * FROM brands LIMIT $numberOfRecordsPrePage OFFSET $skipOfRecords";

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

    /* Add Brand */
    public function addBrand($brand_name, $logo)
    {
        $sql = "INSERT INTO `brands` (`brand_name`, `logo`) VALUES(?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $brand_name, $logo);
        $result = $stmt->execute() or die($this->con->error);
        if ($result) {
            return "BRAND_ADDED";
        } else {
            return 0;
        }
    }

    /* Update Brand */
    public function updateBrand($brand_id, $brand_name)
    {
        $sql = "UPDATE `brands` SET `brand_name` = ? WHERE `brand_id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $brand_name, $brand_id);
        $result = $stmt->execute() or die($this->con->error);
        if ($result) {
            return "BRAND_UPDATED";
        } else {
            return 0;
        }
    }

    /* Delete Brand */
    public function deleteBrand($brand_id)
    {
        $sql = "DELETE FROM `brands` WHERE `brand_id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $brand_id);
        $result = $stmt->execute() or die($this->con->error);

        if ($result) {
            return "BRAND_DELETED";
        } else {
            return 0;
        }
    }
}