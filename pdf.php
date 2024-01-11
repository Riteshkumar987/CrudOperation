<?php
include("connection.php");

if (isset($_GET['export']) && $_GET['export'] == 'pdf') {
    require('fpdf/fpdf.php');

    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Student Information', 0, 1, 'C');
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    $pdf = new PDF();
    $pdf->AddPage('L');
    $pdf->SetFont('Arial', 'B', 8);

    $pdf->Cell(60, 20, 'Username', 1);
    $pdf->Cell(20, 20, 'First Name', 1);
    $pdf->Cell(20, 20, 'Last Name', 1);
    $pdf->Cell(20, 20, 'Gender', 1);
    $pdf->Cell(20, 20, 'Country', 1);
    $pdf->Cell(20, 20, 'State', 1);
    $pdf->Cell(20, 20, 'City', 1);
    $pdf->Cell(40, 20, 'Hobbies', 1);
    $pdf->Cell(30, 20, 'Image', 1);
    $pdf->Ln();

    $sql = "SELECT student.*, countries.country_name, states.state_name, cities.city_name
            FROM student
            LEFT JOIN countries ON student.country = countries.country_id
            LEFT JOIN states ON student.state = states.state_id
            LEFT JOIN cities ON student.city = cities.city_id";

    $data = mysqli_query($conn, $sql);

    while ($result = mysqli_fetch_assoc($data)) {
        $pdf->Cell(60, 20, $result['username'], 1);
        $pdf->Cell(20, 20, $result['firstname'], 1);
        $pdf->Cell(20, 20, $result['lastname'], 1);
        $pdf->Cell(20, 20, $result['gender'], 1);
        $pdf->Cell(20, 20, $result['country_name'], 1);
        $pdf->Cell(20, 20, $result['state_name'], 1);
        $pdf->Cell(20, 20, $result['city_name'], 1);

        $hobbies = unserialize($result['hobbies']);
        $pdf->Cell(40, 20, implode(', ', $hobbies), 1);
       
        $imagePath = './'.$result['image'];

        if (file_exists($imagePath)) {

            $pdf->Cell(30, 20, $pdf->Image($imagePath, $pdf->GetX(), $pdf->GetY(), 20), 1, 0, 'C');
        } else {
            $pdf->Cell(30, 20, 'Image Not Found', 1, 0, 'C');
        }
        $pdf->Ln();

    }

    $pdf->Output('student.pdf', 'D');
    exit();
}

mysqli_close($conn);
?>