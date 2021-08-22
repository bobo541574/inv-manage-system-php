<?php

include_once("../database/constants.php");
include_once("../database/Database.php");
include_once("Category.php");
include_once("Brand.php");
include_once("Product.php");

if (isset($_FILES['file'])) {
    $product = new Product();
    $result = $product->photoUpload($photo = $_FILES['file']);
    echo $result;

    exit();
}

if (isset($_GET['product_id'])) {
    $result = new Product();
    $product = $result->getSingleProduct($_GET['product_id']);

    header("location: " . DOMAIN . "/products.php?product=" . json_encode($product));

    exit();
}

/* Add Product */
if (isset($_POST['product_name']) && isset($_POST['photo'])) {
    $result = new Product();
    $product = $result->addProduct($_POST);
    // $product = $result->addProduct($_POST['product_name'], $_POST['photo'], $_POST['category_id'], $_POST['brand_id'], $_POST['color'], $_POST['size'], $_POST['price'], $_POST['quantity']);
    echo $product;

    exit();
}

/* Fetch All Product */
if (isset($_POST['current_page'])) {
    $result = new Product();
    $products = $result->getProductsWithPagination($_POST['current_page']);
    echo json_encode($products);

    exit();
}

/* Edit Selected Product */
if (isset($_POST['product_name']) && isset($_POST['product_id'])) {
    $result = new Product();
    $category = $result->updateProduct($_POST);

    echo $category;

    exit();
}

/* Change Product Status */
if (isset($_POST['product_id']) && isset($_POST['product_status'])) {
    $result = new Product();
    $product = $result->statusProduct($_POST['product_id'], $_POST['product_status']);

    echo $product;

    exit();
}

/* Delete Selected Product */

if (isset($_POST['product_id'])) {
    $result = new Product();
    $product = $result->deleteProduct($_POST['product_id']);

    echo $product;
}