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
if (isset($_POST['current_page'])) {
    $result = new Category();
    $categories = $result->getCategoriesWithPagination($_POST['current_page']);
    echo json_encode($categories);

    exit();
}

/* Edit Selected Category */
if (isset($_POST['category_name']) && isset($_POST['parent_cat_id']) && isset($_POST['category_id'])) {
    $result = new Category();
    $category = $result->updateCategory($_POST['category_id'], $_POST['parent_cat_id'], $_POST['category_name']);

    echo $category;

    exit();
}

/* Change Category Status */
if (isset($_POST['category_id']) && isset($_POST['category_status'])) {
    $result = new Category();
    $category = $result->statusCategory($_POST['category_id'], $_POST['category_status']);

    echo $category;

    exit();
}

/* Delete Selected Category */

if (isset($_POST['category_id'])) {
    $result = new Category();
    $category = $result->deleteCategory($_POST['category_id']);

    echo $category;
}