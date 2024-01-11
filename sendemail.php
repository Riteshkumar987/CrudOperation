<?php
session_start();
include("connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>forgot Password</title>
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
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Username" name="email"
                                        value="<?php echo isset($result['username']) ? $result['username'] : ''; ?>">
                                </div>
                            </div>

                            <input type="submit" name="sendemail"
                                class="btn btn-primary btn-block font-weight-bold btn-lg" value="SendEmail">
                                <div class="form-group text-right mt-2">
                                <div class="form-controal">
                                    <a href="login.php" class="link-primary  text-white">Login Page</a>
                                </div>
                            </div>
                            <div class="form-group  text-right mt-2">
                                <div class="form-controal">
                                    <a href="registrationform.php" class="link-primary text-white">Register Page</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $errors = [];
    $username = "";
    if (isset($_POST['sendemail'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $query = "SELECT username FROM student WHERE username='$email'";
        $results = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($results);
        $total = mysqli_num_rows($results);


        if ($total > 0) {
            if (empty($email)) {
                array_push($errors, "Your email is required");
            } else if (mysqli_num_rows($results) <= 0) {
                array_push($errors, "Sorry, no user exists on our system with that email");
            }

            $token = bin2hex(random_bytes(50));
            date_default_timezone_set('Asia/kolkata');
            $expiration_time = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $sql = "UPDATE student SET token='$token', expiration_time='$expiration_time' WHERE username='$email'";
            $results = mysqli_query($conn, $sql);

            

            $to = $email;
            $output = "please click on link for reset password";
            $subject = "Reset your password on examplesite.com";
            $body = "Hi there, click on this <a href='http://localhost/registraion/newpassword.php?token=$token'>link</a> to reset your password on our site";
            $body = wordwrap($body, 70);
            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ritesh.kumar@vivanwebsolution.com';
                $mail->Password = 'kfnssblzqxwrzwnz';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('ritesh.kumar@vivanwebsolution.com', 'Mailer');
                $mail->addAddress($email, 'Joe User');

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                echo '<script>alert("Message has been sent")</script>';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        else{
            echo '<script>alert("Email is not exist")</script>';

        }
    }
    ?>
</body>

</html>