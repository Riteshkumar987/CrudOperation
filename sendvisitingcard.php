<?php
session_start();
require('fpdf/fpdf.php');
require 'vendor/autoload.php'; 

include("connection1.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PDF extends FPDF
{
}

$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 10, 'First Name', 1);
$pdf->Cell(20, 10, 'Last Name', 1);
$pdf->Cell(40, 10, 'Company Name', 1);
$pdf->Cell(20, 10, 'Address', 1);
$pdf->Cell(50, 10, 'Email', 1);
$pdf->Cell(30, 10, 'Phone', 1);
$pdf->Cell(20, 10, 'Message', 1);

$pdf->Ln();

if (isset($_GET['id'])) {
    $editId = $_GET['id'];
    $sql = "SELECT * FROM visiting WHERE id='$editId'";
    $data = mysqli_query($conn, $sql);
    
    $result = mysqli_fetch_assoc($data);
    
    while ($result) {
        $pdf->Cell(20, 10, $result['fname'], 1);
        $pdf->Cell(20, 10, $result['lname'], 1);
        $pdf->Cell(40, 10, $result['cname'], 1);
        $pdf->Cell(20, 10, $result['address'], 1);
        $pdf->Cell(50, 10, $result['email'], 1);
        $pdf->Cell(30, 10, $result['phone'], 1);
        $pdf->Cell(20, 10, $result['message'], 1);

        $pdf->Ln();

        $pdfFileName = "exported_pdf.pdf";
        $pdf->Output($pdfFileName, 'F');

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ritesh.kumar@vivanwebsolution.com';
            $mail->Password = 'kfnssblzqxwrzwnz';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('ritesh.kumar@vivanwebsolution.com', 'Your Name');
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

        $result = mysqli_fetch_assoc($data);
    }
    
    mysqli_close($conn);
} else {
    echo 'Invalid ID';
}
?>
