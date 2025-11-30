<?php
session_start();
$valid_username = "admin";
$valid_password = "123";
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username;
        header('Location: welcome.php');
        exit();
    }else{
        header('Location: login.html?error=1');
        exit();
    }
} else {
    header('Location: login.html');
    exit();
}
?>  