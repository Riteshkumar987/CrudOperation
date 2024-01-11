<?php
include("connection.php");
function checkemail($username) {
    return preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $username);
}
if (!empty($_POST['username'])) {
    $username = $_POST['username'];
    $query = "SELECT * FROM student WHERE username='" . $_POST['username'] . "'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "<span style='color:red'>already registered.</span>";
        
        
    } else {
        if(checkemail($username))
        {
            echo "<span style='color:green'>User available for registration.</span>";
        }else{
            echo "email is invalid";
        }
        
    }
}


?>

