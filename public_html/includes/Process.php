<?php

include_once("../database/Database.php");
include_once("ParentCategory.php");
include_once("Category.php");

if (isset($_POST['getParentCategory'])) {
    $result = new ParentCategory();
    $categories = $result->getAllCategories();
    foreach ($categories as $category) {
        echo "<option value=" . $category['parent_cat_id'] . ">" . $category['parent_cat_name'] . "</option>";
    }
    exit();
}

if (isset($_POST['category_name']) && isset($_POST['parent_cat_id']) && !isset($_POST['category_id'])) {
    $result = new Category();
    $category = $result->addCategory($_POST['parent_cat_id'], $_POST['category_name']);
    echo $category;

    exit();
}

/* Fetch All Category */
if (isset($_POST['getCategory'])) {
    $result = new Category();
    $categories = $result->getAllCategories();
    echo json_encode($categories);

    exit();
}

if (isset($_POST['category_name']) && isset($_POST['parent_cat_id']) && isset($_POST['category_id'])) {
    echo "EDIT";
}