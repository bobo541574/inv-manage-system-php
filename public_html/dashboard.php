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
                    <div class="jumbotron shadow" style=" width:100%; height:100%;">
                        <p>Welcome Admin, </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <iframe
                                    src="http://free.timeanddate.com/clock/i7grmx9o/n208/szw160/szh160/cf100/hnce1ead6/fdi78"
                                    frameborder="0" width="160" height="160"></iframe>

                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">New Order</h5>
                                        <p class="card-text">Here you can make invoices and new orders</p>
                                        <a href="#" class="btn btn-primary">New Orders</a>
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
                            <a href="#" class="btn btn-warning">Manage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <?php include_once('./templates/parent_category_modal.php') ?>
        <?php include_once('./templates/category_modal.php') ?>
        <?php include_once('./templates/brand_modal.php') ?>
    </section>

    <!-- JS, Popper.js, and jQuery -->
    <?php include_once('./templates/scripts.php') ?>

</body>

</html>