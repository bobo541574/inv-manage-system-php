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

    public function addOrder($orders)
    {
        $order_code = "#" . date("Y-m-d h:i") . "-" . strtolower(str_replace(" ", "", $orders['name']));
        $products = json_decode($orders['product_lists']);

        $sql = "INSERT INTO orders (`order_code`, `product_id`, `quantity`, `initial_payment`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        foreach ($products as $product) {
            $stmt->bind_param("sissssss", $order_code, $product->product_id, $product->quantity, $orders['initial'], $orders['name'], $orders['phone'], $orders['email'], $orders['address']);
            $result = $stmt->execute() or die($this->con->error);
            if (!$result) {
                return 0;
            }
        }

        return "PRODUCT_ORDER";
    }

    /* Fetch All Product With Pagination*/
    private function paginate($table, $toCount, $current_page)
    {
        $paginate = [];
        $status = 1;
        $min = 0;
        $numberOfRecordsPrePage = 5;
        $sql =  "SELECT COUNT($toCount) as results FROM $table WHERE status = $status AND quantity > $min";
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

    public function getProductsWithPagination($current_page)
    {
        $paginate = $this->paginate("products", "product_id", $current_page);

        // $sql = "SELECT * FROM Orders LIMIT 10 OFFSET 15";
        $numberOfRecordsPrePage = $paginate["numberOfRecordsPrePage"];
        $skipOfRecords = $paginate["skipOfRecords"];
        $status = 1;
        $min = 0;

        $sql = "SELECT pds.*, cats.category_name, bds.brand_name
        FROM products as pds
        JOIN categories as cats 
        ON pds.category_id = cats.cat_id
        JOIN brands as bds 
        ON pds.brand_id = bds.brand_id WHERE pds.status = ? AND pds.quantity > ? ORDER BY pds.created_data DESC
        LIMIT $numberOfRecordsPrePage OFFSET $skipOfRecords";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("is", $status, $min);
        $stmt->execute() or die($this->con->error);
        $result = $stmt->get_result();
        $paginatedRecords = [];
        $rows = [];
        // echo $result->num_rows;
        // die();
        // exit();
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
}