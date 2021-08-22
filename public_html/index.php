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
            <div class="card mx-auto shadow" style="width: 30rem;">
                <div class="card-header h4">
                    Login Form
                </div>
                <?php if (!empty($_GET['msg'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <strong>Welcome!</strong> <?php echo $_GET['msg'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif ?>
                <img src="./images/login.png" class="card-img-top mx-auto my-2" style="width: 45%;" alt="...">
                <div class="card-body">
                    <form id="login_form" onsubmit="return false" autocomplete="off">
                        <input type="hidden" name="login" value="LOGIN">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   placeholder="Enter Email">
                            <small id="email_error" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Enter Password">
                            <small id="password_error" class="form-text text-muted"></small>
                        </div>
                        <button type="submit" value="Login" class="btn btn-primary mr-2"><i
                                    class="fa fa-unlock"></i>
                            Submit
                        </button>
                        <span><a href="<?php echo DOMAIN . "/register.php" ?>">Register</a></span>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="">Forget Password ?</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JS, Popper.js, and jQuery -->
<?php include_once('./templates/scripts.php') ?>

<script src="./js/login.js"></script>

</body>

</html>