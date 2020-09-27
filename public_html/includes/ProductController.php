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
    // echo "<pre>";
    // print_r($product);
    // echo "</pre>";
    header("location: " . DOMAIN . "/products.php?product=" . json_encode($product));

    exit();
}

/* Add Product */
if (isset($_POST['product_name']) && isset($_POST['photo'])) {
    $result = new Product();
    $product = $result->addProduct($_POST);
    // $product = $result->addProduct($_POST['product_name'], $_POST['photo'], $_POST['category_id'], $_POST['brand_id'], $_POST['color'], $_POST['size'], $_POST['price'], $_POST['quantity']);
    echo $product;

    // echo "<pre>";
    // print_r($product);
    // echo "</pre>";

    exit();
}

/* Fetch All Category */
if (isset($_POST['current_page'])) {
    $result = new Product();
    $products = $result->getProductsWithPagination($_POST['current_page']);
    echo json_encode($products);

    exit();
}

/* Edit Selected Category */
if (isset($_POST['category_name']) && isset($_POST['parent_cat_id']) && isset($_POST['category_id'])) {
    $result = new Product();
    $category = $result->updateCategory($_POST['category_id'], $_POST['parent_cat_id'], $_POST['category_name']);

    echo $category;

    exit();
}

/* Change Category Status */
if (isset($_POST['category_id']) && isset($_POST['category_status'])) {
    $result = new Product();
    $category = $result->statusCategory($_POST['category_id'], $_POST['category_status']);

    echo $category;

    exit();
}

/* Delete Selected Category */

if (isset($_POST['category_id'])) {
    $result = new Product();
    $category = $result->deleteCategory($_POST['category_id']);

    echo $category;
}