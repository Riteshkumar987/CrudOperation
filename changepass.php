<?php
include("connection.php");
session_start();

$id = null;
$resu = array();
if (isset($_COOKIE['id'])) {
    $id = $_COOKIE['id'];
} elseif (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
if (is_null($id)) {
    header('location:login.php');
    exit();
}

$sql = "SELECT * FROM student WHERE id='$id'";
$res = mysqli_query($conn, $sql);

if ($res) {
    $resu = mysqli_fetch_assoc($res);
} else {
    echo "<script>alert('Unable to fetch user data');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>

<body class="">
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar vh-100">
                <div class="sidebar-sticky h-100">
                    <h5 class="my-4 text-light">Admin Name</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-light" href="display.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="login.php">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#">
                                Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-10 ml-sm-auto px-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"></h1>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle rounded-pill" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (isset($resu['image'])): ?>
                            <img src="<?php echo $resu['image']; ?>" alt="Profile Image" width="25"
                                class="rounded-circle" style="object-fit: cover;">
                            <?php endif; ?>
                            <span style="margin-left: 10px;">
                                <?php echo $resu['firstname'] . " " . $resu['lastname']; ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <li><a class="dropdown-item" href="#">Change Password</a></li>
                        </ul>
                    </div>
                </div>

                <div class="container">
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body shadow-lg p-4 custom-bg-color">
                                    <?php
                                    if (!isset($_POST['changepassword'])) {
                                    ?>
                                    <form action="" class="login" method="post">
                                        <div class="form-group">
                                            <label for="oPass">Old Password:</label>
                                            <input class="form-control" type="password" placeholder="Old Password"
                                                name="oPass">
                                        </div>
                                        <div class="form-group">
                                            <label for="nPass">New Password:</label>
                                            <input class="form-control" type="password" placeholder="New Password"
                                                name="nPass">
                                        </div>
                                        <div class="form-group">
                                            <label for="cPass">Confirm Password:</label>
                                            <input class="form-control" type="password" placeholder="Confirm Password"
                                                name="cPass">
                                        </div>
                                        <button type="submit" name="changepassword"
                                            class="btn btn-primary btn-block font-weight-bold btn-lg">Change
                                            Password</button>
                                    </form>
                                    <?php
                                    } else {
                                        $oldpassword = md5($_POST['oPass']);
                                        $newpassword = md5($_POST['nPass']);
                                        $confirmpassword = md5($_POST['cPass']);

                                        $checkOldPasswordQuery = "SELECT password FROM student WHERE password='$oldpassword'";
                                        $result = mysqli_query($conn, $checkOldPasswordQuery);
                                        $row = mysqli_fetch_assoc($result);

                                        if (!$row) {
                                            echo "<script>alert('Your old password is incorrect')</script>";
                                        } else {
                                            if ($newpassword == $confirmpassword) {
                                                $updatePasswordQuery = "UPDATE student SET password='$newpassword' WHERE password='$oldpassword'";
                                                $updateResult = mysqli_query($conn, $updatePasswordQuery);

                                                if ($updateResult) {
                                                    echo "<script>alert('Password changed successfully')</script>";
                                                    echo "<script>location.href='login.php';</script>";
                                                } else {
                                                    echo "<script>alert('Error updating password')</script>";
                                                }
                                            } else {
                                                echo "<script>alert('Your new password and confirm password do not match')</script>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>

</html>