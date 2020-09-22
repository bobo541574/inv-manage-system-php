<?php

include_once("./database/constants.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>

    <!-- CSS only -->
    <?php include_once('./templates/styles.php') ?>

</head>

<body>
    <div class="overlay">
        <div class="loader"></div>
    </div>
    <header>
        <?php include_once('./templates/header.php') ?>
    </header>
    <section class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow">
                        <div class="card-header h4">
                            Category List
                        </div>
                        <?php if (!empty($_GET['msg'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <strong>Welcome!</strong> <?php echo $_GET['msg'] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif ?>
                        <div class="card-body p-0">
                            <table class="table table-striped table-inverse table-hover text-center">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>No.</th>
                                        <th>Category</th>
                                        <th>Parent Category</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cat_list" data-value="List">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <?php include_once('./templates/edit_category_modal.php') ?>
            <?php include_once('./templates/brand_modal.php') ?>
            <?php include_once('./templates/product_modal.php') ?>
        </div>
    </section>

    <!-- JS, Popper.js, and jQuery -->
    <?php include_once('./templates/scripts.php') ?>

</body>

</html>