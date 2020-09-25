<?php

include_once("../database/Database.php");
include_once("Brand.php");

/* Fetch All Parent Category */
if (isset($_POST['current_page'])) {
    $result = new Brand();
    $brands = $result->getCategoriesWithPagination($_POST['current_page']);
    echo json_encode($brands);

    exit();
}

/* Add Parent Category */
if (isset($_POST['brand_name']) && isset($_POST['logo']) && !isset($_POST['brand_id'])) {
    $result = new Brand();
    $parent_category = $result->addBrand($_POST['brand_name'], $_POST['logo']);
    echo $parent_category;

    exit();
}

/* Edit Parent Category */
if (isset($_POST['brand_id']) && isset($_POST['brand_name'])) {
    $result = new Brand();
    $brand = $result->updateBrand($_POST['brand_id'], $_POST['brand_name']);
    echo $brand;

    exit();
}

/* Delete Parent Category */
if (isset($_POST['brand_id'])) {
    $result = new Brand();
    $brand = $result->deleteBrand($_POST['brand_id']);
    echo $brand;

    exit();
}