<?php

class Product
{

    private $con;

    public function __construct()
    {
        include_once("../database/Database.php");

        $db = new Database();
        $this->con = $db->connect();
    }

    public function photoUpload($photo)
    {
        $photo_name = $photo['name'];
        $tmp_name = $photo['tmp_name'];

        /* Uploaded File Type */
        $type = $photo['type'];

        /* Upload Location */
        $dir = BASE_LOCATION . "/images/products/";

        /* Valid File Types */
        $valid_extensions = array("image/jpg", "image/jpeg", "image/png");

        /* File Type Validation */
        $valid = in_array(strtolower($type), $valid_extensions) ? true : false;

        $file_exist = file_exists($dir . $photo_name) ? true : false;

        if (!$file_exist) {
            if ($valid) {
                if (move_uploaded_file($tmp_name, $dir . $photo_name)) {
                    return "PHOTO_UPLOADED";
                } else {
                    return "SOMETHING_WRONG";
                }
            } else {
                return "INVALID_FILE_TYPE";
            }
        } else {
            return "FILE_ALREADY_EXIST";
        }
    }
    public function addProduct(...$arg)
    {
        $product_code = "SKU-C{$arg[0]['category_id']}B{$arg[0]['brand_id']}-" . strtoupper($arg[0]['color']) . "-" . strtoupper($arg[0]['product_name']);
        // return $product_code;

        $sql = "INSERT INTO `products` (`product_code`, `product_name`, `photo`, `category_id`, `brand_id`, `color`, `size`, `price`, `quantity`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sssiissss", $product_code, $arg[0]['product_name'], $arg[0]['photo'], $arg[0]['category_id'], $arg[0]['brand_id'], $arg[0]['color'], $arg[0]['size'], $arg[0]['price'], $arg[0]['quantity']);
        $result = $stmt->execute() or die($this->con->error);
        if ($result) {
            return "PRODUCT_ADDED";
        } else {
            return 0;
        }
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

    public function getSingleProduct($product_id)
    {
        $sql = "SELECT * FROM `products` WHERE `product_id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute() or die($this->con->error);
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    public function getAllProducts()
    {
        $stmt = $this->con->prepare(
            "SELECT *, cats.category_name, bds.brand_name, sku.sku_code, sku.color, sku.size, sku.price, sku.quantity
            FROM products as pds 
            JOIN categories as cats 
            ON pds.category_id = cats.cat_id
            JOIN brands as bds 
            ON pds.brand_id = bds.brand_id
            JOIN sku
            ON pds.sku_code = sku.sku_code"
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

    public function getProductsWithPagination($current_page)
    {
        $paginate = $this->paginate("products", "product_id", $current_page);

        // $sql = "SELECT * FROM Orders LIMIT 10 OFFSET 15";
        $numberOfRecordsPrePage = $paginate["numberOfRecordsPrePage"];
        $skipOfRecords = $paginate["skipOfRecords"];

        $sql = "SELECT pds.*, cats.category_name, bds.brand_name
        FROM products as pds 
        JOIN categories as cats 
        ON pds.category_id = cats.cat_id
        JOIN brands as bds 
        ON pds.brand_id = bds.brand_id ORDER BY pds.created_data DESC
        LIMIT $numberOfRecordsPrePage OFFSET $skipOfRecords";

        $stmt = $this->con->prepare($sql);
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

// $products = new Product();
// echo "<pre>";
// print_r($products->addProduct("Bo Bo", "May"));
// echo "</pre>";