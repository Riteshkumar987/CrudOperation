<?php
include("connection.php");

if (!empty($_POST['password'])) {
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password != $cpassword) {
        echo "<span style='color:red'>Your password and confirm password do not match.</span>";
    } else {
        if (strlen($password) < 6) {
            echo "<span style='color:red'>Password should be at least 6 characters long.</span>";
        } else {
            echo "<span style='color:green'>Valid.</span>";
        }
    }
}
?>
