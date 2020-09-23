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
    <header>
        <?php include_once('./templates/header.php') ?>
    </header>
    <section class="my-5">
        <div class="container">
            <div class="card text-left" style="width:30rem; margin:0 auto; ">
                <div class="card-header h4">Register Form</div>
                <div class="card-body">
                    <small id="confirm" class="form-text text-center text-muted"></small>
                    <form id="register_form" onsubmit="return false" method="POST" autocomplete="off">
                        <input type="hidden" name="register" value="REGISTER">
                        <div class="form-group">
                            <label for="username">Full Name</label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Enter Username">
                            <small id="username_error" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email"
                                aria-describedby="helpId">
                            <small id="email_error" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Enter Password" aria-describedby="helpId">
                            <small id="password_error" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                placeholder="Enter Confirm Password" aria-describedby="helpId">
                            <small id="confirm_password_error" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="user_type">User Type</label>
                            <select class="form-control" name="user_type" id="user_type">
                                <option value="">Choose User Type</option>
                                <option value="0">Admin</option>
                                <option value="1">Other</option>
                            </select>
                            <small id="user_type_error" class="form-text text-muted"></small>
                        </div>
                        <button type="submit" name="user_register" class="btn btn-primary mr-2"><i
                                class="fa fa-registered"></i>
                            Register </button>
                        <a href="<?php echo DOMAIN . "/" ?>">Already Registered ?</a>

                    </form>
                </div>
                <div class="card-footer">
                    <a href="">Forgotten Password ?</a>
                </div>
            </div>
        </div>
    </section>

    <!-- JS, Popper.js, and jQuery -->
    <?php include_once('./templates/scripts.php') ?>

    <script src="./js/register.js"></script>

</body>

</html>