<?php
session_start();
require 'vendor/autoload.php'; 

include("connection1.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


if (isset($_GET['id'])) {
    $editId = $_GET['id'];
    
    $editId = mysqli_real_escape_string($conn, $editId);
    
    $sql = "SELECT * FROM visiting WHERE id='$editId'";
    $data = mysqli_query($conn, $sql);
    
    if ($data) {
        $result = mysqli_fetch_assoc($data);

       include("pdf3.php");

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ritesh.kumar@vivanwebsolution.com';
            $mail->Password = 'kfnssblzqxwrzwnz';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('ritesh.kumar@vivanwebsolution.com', $result['fname']);
            $mail->addAddress($result['email'], 'Recipient Name');

            $mail->isHTML(true);
            $mail->Subject = 'Your Subject';
            $mail->Body = 'Your email body content.';

            $mail->addAttachment($pdfFileName);

            $mail->send();

            echo 'Email sent successfully!';
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Error fetching data from the database.';
    }
} else {
    echo 'Invalid ID';
}
?>
