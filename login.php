<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login Page</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-5">
                <div class="card bg-secondary text-white">
                    <div class="card-body shadow-lg p-4 custom-bg-color">
                        <div class="text-center mb-4">
                            <h4 class="text-white font-weight-bold bg-primary pt-2" style="height: 50px;">SIGN IN</h4>
                            <img src="image/user.png" class="rounded-circle" alt="User Image" width="150" height="150">
                        </div>

                        <form action="" class="login" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Username" name="Uname"
                                        value="<?php echo isset($_COOKIE["Uname"]) ? htmlspecialchars($_COOKIE["Uname"]) : ''; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" type="password" placeholder="Password" name="Pass"
                                        value="<?php echo isset($_COOKIE["Pass"]) ? htmlspecialchars($_COOKIE["Pass"]) : ''; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rem" name="rememberme"
                                            <?php if(isset($_COOKIE["Uname"])) { ?> checked <?php } ?>>
                                        <label class="form-check-label" for="rem">Remember me</label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="sendemail.php" class="text-white">Forgot Password?</a><br>
                                    <a href="registrationform.php" class="text-white font-weight-bold">New user?</a>
                                </div>
                            </div>

                            <input type="submit" name="login" class="btn btn-primary btn-block font-weight-bold btn-lg"
                                value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("loginverify.php"); ?>
</body>

</html>