<?php

include_once("./database/constants.php");

if (!isset($_SESSION["id"])) {
    return header("location: " . DOMAIN . "/index.php");
}

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
            <div class="row my-2">
                <div class="col-md-12 mx-auto">
                    <div class="card shadow">
                        <div class="card-header h4">
                            Product List
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-hover text-center" id="ordering"
                                    style="font-size: medium;">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>No.</th>
                                            <th>Photo</th>
                                            <th>Product</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product_order" data-value="Product_Order">

                                    </tbody>

                                    <!-- Delete Confrimation -->
                                    <div class="modal fade" id="delete_confirm" tabindex="-1"
                                        aria-labelledby="delete_confirm_label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-warning" id="delete_confirm_label">
                                                        <i class="fa fa-exclamation-triangle"></i>
                                                        Confirmation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="brand_delete" onsubmit="return false">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="product_id" id="product_id">
                                                        <div class="text-center h5">Are you sure? You want
                                                            to delete...!
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </table>
                            </div>
                        </div>
                        <div id="paginator">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-md-12">
                    <div class="jumbotron shadow">
                        <div class="row my-1">
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <img class="card-img-top" src="holder.js/100px180/" alt="">
                                    <div class="card-header h4">
                                        Customer Order Lists
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="customer_ordering"
                                                class="table table-striped table-inverse table-hover text-center"
                                                style="font-size: medium;">
                                                <thead class="thead-inverse">
                                                    <th>No</th>
                                                    <th>Product Coode</th>
                                                    <th>Product Name</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Sub Total Price</th>
                                                    <th>Action</th>
                                                </thead>
                                                <tbody id="customer_order_list">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- JS, Popper.js, and jQuery -->
    <?php include_once('./templates/scripts.php') ?>

</body>

</html>