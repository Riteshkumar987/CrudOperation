<?php
session_start();
include("connection.php");
$errors = [];

// if (isset($_SESSION['id'])) {
//     $id = $_SESSION['id'];
    
// }

// $sql = "SELECT * FROM student WHERE id='$id'";
// $res = mysqli_query($conn, $sql);
// $result = mysqli_fetch_assoc($res);
$token = $_GET['token'];
$username = "";
if (isset($_POST['forgotpassword'])) {
    $new_pass = mysqli_real_escape_string($conn, $_POST['nPass']);
    $new_pass_c = mysqli_real_escape_string($conn, $_POST['cPass']);

    // if (empty($new_pass) || empty($new_pass_c)) {
    //     array_push($errors, "Password is required");
    // }

    // if ($new_pass !== $new_pass_c) {
    //     array_push($errors, "Password do not match");
    // }

    // if (count($errors) == 0) {
    $sql = "SELECT username, expiration_time FROM student WHERE token='$token'";
    $results = mysqli_query($conn, $sql);

    if ($results) {
        $resetData = mysqli_fetch_assoc($results);
        $email = $resetData['username'];

        $current_time = time();
        $expiration_time = strtotime($resetData['expiration_time']);

        if ($current_time > $expiration_time) {
            echo "<script>alert('The link has expired. Please request a new password reset.')</script>";
        } else {
            $new_pass = md5($new_pass);
            $sql = "UPDATE student SET password='$new_pass' WHERE username='$email'";
            $results = mysqli_query($conn, $sql);

            if ($results) {
                echo "<script>alert('Password changed successfully')</script>";
                $updateTokenSql = "UPDATE student SET token=NULL, expiration_time=NULL WHERE username='$email'";
                mysqli_query($conn, $updateTokenSql);
                echo "<script>location.href='login.php';</script>";
            } else {
                echo "Error updating password";
            }
        }

    } else {
        echo "Error querying database";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>New Password</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <div class="card bg-secondary text-white">
                    <div class="card-body shadow-lg p-4 custom-bg-color">
                        <form action="" class="login" method="post">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" type="password" placeholder="New Password" name="nPass">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" type="password" placeholder="confirm Password"
                                        name="cPass">
                                </div>
                            </div>

                            <input type="submit" name="forgotpassword"
                                class="btn btn-primary btn-block font-weight-bold btn-lg" value="Change_password">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>