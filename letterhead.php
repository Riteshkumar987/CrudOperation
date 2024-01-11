<?php
include("connection1.php");
ob_start();

require('fpdf/fpdf.php');

if (isset($_GET['export']) && $_GET['export'] == 'pdf') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'display.php');
    $pdf->Output('display.pdf', 'D');
   
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigmWqe6BwsGA4lH8SDd6U49aaQ=="
        crossorigin="anonymous">

    <title>Dashboard</title>
</head>

<body class="bg-light">
    <div>
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar vh-100">
                <div class="sidebar-sticky h-100">
                    <h5 class="my-4 text-light">Admin Name</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-light" href="dashbord.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="display.php">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="displaymeb.php">
                                Visiting
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="letterhead.php">
                                LetterHead
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-10 ml-sm-auto px-4">
            <div class="col py-3">
                <div class="container mt-5">
                    <header class="text-center bg-secondary text-white py-4">
                        <h1 class="display-4">Vivan web Solution</h1>
                        <p class="lead">Address: G-401,SG Business Hub Sarkhej- Gandhinagar Hwy, gota,Ahmedabad, Gujrat</p>
                        <p class="lead">Phone: +91 (987) 518-0954 | Email: info@vivanwebsolution.com</p>
                    </header>

                    <div class="row mt-4">
                        <div class="col-md-8">
                            <p class="lead">Date: January 1, 2023</p>
                            <h2>Recipient Name</h2>
                            <p>Recipient's Address: 456 Recipient Street, City, Country</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-8">
                            <p class="lead">Dear [Recipient Name],</p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit dignissim
                                felis, a
                                scelerisque mauris varius vitae. Vestibulum fermentum mauris vel velit accumsan, vel
                                scelerisque tellus tristique. Nullam hendrerit justo ac sapien consectetur, nec
                                dignissim mi
                                convallis. Sed ut quam vel odio malesuada fermentum.
                            </p>
                            <p class="mt-4">
                                Sincerely,<br>
                                Ritesh kumar<br>
                                PHP developer<br>
                                vivanwebsolution
                            </p>
                          
                           

                        </div>
                        
                    </div>
                </div>

            </div>


            </main>
        </div>
    </div>
</body>

</html>



