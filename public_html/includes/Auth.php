<?php

include_once("../database/constants.php");
include_once("User.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['login'] == "LOGIN") {
    $user = new User();
    $result = $user->loginUser($_POST['email'], $_POST['password']);
    echo $result;

    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['register'] == "REGISTER") {
    $user = new User();
    $result = $user->createUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['user_type']);
    echo $result;

    exit();
} else {
    echo "Invalid";
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['logout'] == "LOGOUT") {
    if (isset($_SESSION['id'])) {
        session_destroy();
        header("location: " . DOMAIN . "/");

        exit();
    } else {
        return 1;
    }
}