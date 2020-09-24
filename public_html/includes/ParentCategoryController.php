<?php

include_once("../database/Database.php");
include_once("ParentCategory.php");

/* Fetch All Parent Category */
if (isset($_POST['current_page'])) {
    $result = new ParentCategory();
    $parent_categories = $result->getCategoriesWithPagination($_POST['current_page']);
    echo json_encode($parent_categories);

    exit();
}

/* Add Parent Category */
if (isset($_POST['parent_category_name']) && !isset($_POST['parent_cat_id'])) {
    $result = new ParentCategory();
    $parent_category = $result->addParentCategory($_POST['parent_category_name']);
    echo $parent_category;

    exit();
}

/* Edit Parent Category */
if (isset($_POST['parent_cat_id']) && isset($_POST['parent_category_name'])) {
    $result = new ParentCategory();
    $parent_category = $result->updateParentCategory($_POST['parent_cat_id'], $_POST['parent_category_name']);
    echo $parent_category;

    exit();
}

/* Delete Parent Category */
if (isset($_POST['parent_cat_id'])) {
    $result = new ParentCategory();
    $parent_category = $result->deleteParentCategory($_POST['parent_cat_id']);
    echo $parent_category;

    exit();
}