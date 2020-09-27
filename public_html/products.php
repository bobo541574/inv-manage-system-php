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
                <div class="col-md-12 mx-auto">
                    <div class="card shadow">
                        <div class="card-header h4">
                            Product List
                        </div>
                        <?php if (!empty($_GET['msg'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <strong>Welcome!</strong> <?php echo $_GET['msg'] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif ?>
                        <div class="card-body">
                            <?php if (isset($_GET['product'])) :
                                $product = json_decode($_GET['product']);
                                echo "<pre>";
                                print_r($product);
                                echo "</pre>";
                            ?>
                            <?php endif; ?>
                            <form id="edit_prod_modal" onsubmit="return false" autocomplete="off"
                                enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="product_name" id="product_name"
                                                value="<?php echo $product->product_name ?>" class="form-control"
                                                placeholder="Enter Category">
                                            <small id="product_name_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" name="photo" id="photo" onchange="loadFile()"
                                                    class="custom-file-input" placeholder="Enter Photo">
                                                <label class="custom-file-label" for="photo">Choose file</label>
                                                <small id="photo_error" class="form-text text-muted"></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <select class="custom-select" name="category_id" id="category_id">
                                            </select>
                                            <small id="category_id_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group">
                                            <select class="custom-select" name="brand_id" id="brand_id"
                                                value="<?php echo $product->brand_id ?>">
                                            </select>
                                            <small id="brand_id_error" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="color" id="color" class="form-control"
                                                value="<?php echo $product->color ?>" placeholder="Enter Color">
                                            <small id="color_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="size" id="size" class="form-control"
                                                value="<?php echo $product->size ?>" placeholder="Enter Size">
                                            <small id="size_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="price" id="price" class="form-control"
                                                value="<?php echo $product->price ?>" placeholder="Enter Price">
                                            <small id="price_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="quantity" id="quantity" class="form-control"
                                                value="<?php echo $product->quantity ?>" placeholder="Enter Quantity">
                                            <small id="quantity_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="text-right my-2">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- JS, Popper.js, and jQuery -->
    <?php include_once('./templates/scripts.php') ?>
    <script src="./js/product.js"></script>

</body>

</html>