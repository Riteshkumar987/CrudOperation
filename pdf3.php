<?php
   require('fpdf/fpdf.php');


class PDF extends FPDF
{
}

if (isset($_GET['id'])) {
   $editId = $_GET['id'];
   
   $editId = mysqli_real_escape_string($conn, $editId);
   
   $sql = "SELECT * FROM visiting WHERE id='$editId'";
   $data = mysqli_query($conn, $sql);
   
   if ($data) {
       $result = mysqli_fetch_assoc($data);

       $pdf = new PDF();
       $pdf->AddPage();

       $pdf->SetFont('Arial', '', 12);
       $pdf->Cell(0, 10, $result['cname'], 0, 1, 'C');
       $pdf->Cell(0, 10, 'Address: G-401, SG Business Hub Sarkhej-Gandhinagar Hwy, Gota, Ahmedabad, Gujarat', 0, 1, 'C');
       $pdf->Cell(0, 10, 'Phone: +91 (987) 518-0954 | Email:'.$result['email'], 0, 1, 'C');
       $pdf->Ln(10);

       $pdf->Cell(0, 10, 'Date: January 1, 2023', 0, 1);
       $pdf->Cell(0, 10, 'Recipient Name', 0, 1);
       $pdf->Cell(0, 10, 'Recipient\'s Address: ' . $result['address'], 0, 1);
       $pdf->Ln(10);

       $pdf->Cell(0, 10, 'Dear ' . $result['fname'] . ',', 0, 1);
       $pdf->MultiCell(0, 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit dignissim felis, a scelerisque mauris varius vitae. Vestibulum fermentum mauris vel velit accumsan, vel scelerisque tellus tristique. Nullam hendrerit justo ac sapien consectetur, nec dignissim mi convallis. Sed ut quam vel odio malesuada fermentum.', 0);
       $pdf->Ln(10);

       $pdf->Cell(0, 10, 'Sincerely,', 0, 1);
       $pdf->Cell(0, 10, $result['fname']." ".$result['lname'], 0, 1);
       $pdf->Cell(0, 10, 'PHP developer,', 0, 1);
       $pdf->Cell(0, 10, $result['cname'], 0);
       $pdf->Ln(10);

       $pdfFileName = "exported_pdf.pdf";
       $pdf->Output($pdfFileName, 'F');
   }
}
?>