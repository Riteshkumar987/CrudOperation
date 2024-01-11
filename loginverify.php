<?php
include('connection.php');
if (isset($_COOKIE['id'])) {
    echo "<script>location.href='dashbord.php';</script>";
    exit();
}
if (isset($_SESSION['id'])) {
    echo "<script>location.href='dashbord.php';</script>";
    exit();
}
if (isset($_POST['sgin'])) {
    echo "<script>location.href='registrationform.php';</script>";
}

if (isset($_POST['login'])) {
    $username = $_POST['Uname'];
    $password = md5($_POST['Pass']);
 
    $query = "SELECT * FROM student WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    $sql = "SELECT * FROM student WHERE username='$username'";
    $res = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($res);
    
    if ($count == 1) {
        $id = $result['id'];
        $_SESSION['id'] = $id;
        if (!empty($_POST["rememberme"])) {
            setcookie('id', $id, time() + (8 * 60 * 60));
        }

        echo "<script>location.href='dashbord.php';</script>";
        exit();
    } else {
        echo "<script>alert('Please enter your correct username and password');</script>";
    }
}
?>