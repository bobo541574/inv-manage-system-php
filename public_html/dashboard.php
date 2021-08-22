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
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow mx-auto">
                        <img src="./images/man.png" class="card-img-top mx-auto my-2" style="width: 70%;" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Profile Information</h5>
                            <p class="card-text"><i class="fa fa-user"></i> Bo Bo</p>
                            <p class="card-text"><i class="fa fa-user-shield"></i> Admin</p>
                            <p class="card-text"><i class="fa fa-clock"></i> Last Login : xxx-xxx-xxx </p>
                            <a href="#" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="jumbotron shadow p-4" style=" width:100%; height:100%;">
                        <h1 class="text-center mb-5">Welcome Admin </h1>
                        <div class="row">
                            <div class="col-sm-6" id="clock">
                                <!-- <iframe
                                    src="http://free.timeanddate.com/clock/i7grmx9o/n208/szw160/szh160/cf100/hnce1ead6/fdi78"
                                    frameborder="0" width="160" height="160"></iframe> -->

                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">New Order</h5>
                                        <p class="card-text">Here you can make invoices and new orders</p>
                                        <a href="<?php echo DOMAIN . "/order.php" ?>" class="btn btn-primary">New
                                            Orders</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between my-5">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Manage Parent Category</h5>
                            <p class="card-text">Here you can manage your parent category and add new parent category
                            </p>
                            <a href="#" data-toggle="modal" data-target="#parent_category_modal"
                                class="btn btn-primary">Add
                            </a>
                            <a href="<?php echo DOMAIN . "/parent_categories.php" ?>" class="btn btn-warning">Manage
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Manage Categories</h5>
                            <p class="card-text">Here you can manage your categories and add new parent and sub
                                categories</p>
                            <a href="#" data-toggle="modal" data-target="#category_modal" class="btn btn-primary">Add
                            </a>
                            <a href="<?php echo DOMAIN . "/categories.php" ?>" class="btn btn-warning">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Manage Brands</h5>
                            <p class="card-text">Here you can manage your brands and add new brands</p>
                            <a href="#" data-toggle="modal" data-target="#brand_modal" class="btn btn-primary">Add
                            </a>
                            <a href="<?php echo DOMAIN . "/brands.php" ?>" class="btn btn-warning">Manage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <?php include_once('./templates/parent_category_modal.php') ?>
        <?php include_once('./templates/category_modal.php') ?>
        <?php include_once('./templates/brand_modal.php') ?>
        <?php include_once('./templates/product_modal.php') ?>
        <?php include_once('./templates/edit_product_modal.php') ?>

    </section>

    <section class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="card shadow-lg">
                        <div class="card-header h4">
                            <div class="row justify-content-between m-1">
                                Product List

                                <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#product_modal" id="product">
                                    Add
                                </a>
                            </div>
                        </div>
                        <?php if (!empty($_GET['msg'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif ?>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse table-hover text-center"
                                    style="font-size: medium;">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th style="width: 5%;">No.</th>
                                            <th style="width: 15%;">Photo</th>
                                            <th style="width: 10%;">Product</th>
                                            <th style="width: 10%;">Brand</th>
                                            <th style="width: 10%;">Category</th>
                                            <th style="width: 10%;">Color</th>
                                            <th style="width: 10%;">Size</th>
                                            <th style="width: 10%;">Price</th>
                                            <th style="width: 10%;">Quantity</th>
                                            <th style="width: 10%;">Status</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product_list" data-value="Product_List">

                                    </tbody>

                                    <!-- Delete Confrimation -->
                                    <div class="modal fade" id="delete_confirm" tabindex="-1"
                                        aria-labelledby="delete_confirm_label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-warning" id="delete_confirm_label">
                                                        <i class="fa fa-exclamation-triangle"></i> Confirmation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="brand_delete" onsubmit="return false">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="product_id" id="product_id">
                                                        <div class="text-center h5">Are you sure? You want to delete...!
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

            <!-- Modal -->
        </div>
    </section>

    <!-- JS, Popper.js, and jQuery -->
    <?php include_once('./templates/scripts.php') ?>
    <script src="./js/product.js"></script>
    <script>
    let flag = true;

    let startTimer = () => {
        let today = new Date();
        let day = today.toDateString();
        let time = today.toLocaleTimeString();
        let hour = today.getHours();
        let min = today.getMinutes();
        let sec = today.getSeconds();
        // let clock =
        //     `<h2>${day}</h2><strong style="font-size: 32px;"><i>${hour} : ${min < 10 ? "0" + min : min} : ${sec < 10 ? "0" + sec : sec}</i><strong>`;
        // console.log(hour + " : " + min + " : " + sec + " / " + flag)
        let clock =
            `<h2>${day}</h2><strong style="font-size: 32px;"><i>${time}</i><strong>`;
        document.getElementById('clock').innerHTML = clock;
        setTimeout(startTimer, 1000)
        flag = false;
    }
    flag == true ? startTimer() : '';

    // $(document).ready(function() {
    /* Fetch All Parent Category */
    fetch_parent_categories();

    function fetch_parent_categories() {
        $.ajax({
            url: DOMAIN + "/includes/CategoryController.php",
            method: "POST",
            data: {
                getParentCategory: 1 /* To Check Server Side */ ,
            },
            success: function(data) {
                let choose = "<option value='0'>Choose Parent Category</option>";
                $("form #parent_cat_id").html(choose + data);
            },
        });
    }

    fetch_categories();

    function fetch_categories() {
        $.ajax({
            url: DOMAIN + "/includes/CategoryController.php",
            method: "POST",
            data: {
                getCategory: 1 /* To Check Server Side */ ,
            },
            success: function(data) {
                let choose = "<option value='0'>Choose Category</option>";
                $("#category_id").html(choose + data);
                $("#edit_prod_modal #category_id").html(choose + data);
            },
        });
    }

    fetch_brands();

    function fetch_brands() {
        $.ajax({
            url: DOMAIN + "/includes/BrandController.php",
            method: "POST",
            data: {
                getBrand: 1 /* To Check Server Side */ ,
            },
            success: function(data) {
                let choose = "<option value='0'>Choose Brand</option>";
                $("#brand_id").html(choose + data);
                $("#edit_prod_modal #brand_id").html(choose + data);
            },
        });
    }
    // })
    </script>
</body>

</html>