<?php
include("connection1.php");

if (isset($_GET['export']) && $_GET['export'] == 'pdf') {
    require('fpdf/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage('L');
    $pdf->SetFont('Arial', 'B', 10);

    $pdf->Cell(20, 10, 'First Name', 1);
    $pdf->Cell(20, 10, 'Last Name', 1);
    $pdf->Cell(50, 10, 'Company Name', 1);
    $pdf->Cell(40, 10, 'Address', 1);
    $pdf->Cell(60, 10, 'Email', 1);
    $pdf->Cell(40, 10, 'Phone', 1);
    $pdf->Cell(40, 10, 'Message', 1);
   
    $pdf->Ln();

    $sql = "SELECT * FROM visiting";  

    $data = mysqli_query($conn, $sql);

    while ($result = mysqli_fetch_assoc($data)) {
       
        $pdf->Cell(20, 10, $result['fname'], 1);
        $pdf->Cell(20, 10, $result['lname'], 1);
        $pdf->Cell(50, 10, $result['cname'], 1);
        $pdf->Cell(40, 10, $result['address'], 1);
        $pdf->Cell(60, 10, $result['email'], 1);
        $pdf->Cell(40, 10, $result['phone'], 1);
        $pdf->Cell(40, 10, $result['message'], 1);

        $pdf->Ln();
    }

    mysqli_close($conn); 

    $pdf->Output('students.pdf', 'D'); 
    exit(); 
}
?>
