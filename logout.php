<?php
session_start();

if (isset($_SESSION['id']) || isset($_COOKIE['id'])) {
    unset($_SESSION['id']);
    setcookie("id", "");
    session_destroy();
    echo "<script>location.href='login.php';</script>";
    exit();
} else {
    echo "<script>location.href='login.php';</script>";
    exit();
}
?>
