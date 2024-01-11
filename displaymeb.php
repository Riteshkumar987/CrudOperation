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
                <div class="container mt-5">
                    <h2>Visiting Records</h2>

                    <a class="btn btn-primary mb-3" href='insertmeb.php'>Add Record</a>
                    <a class="btn btn-success mb-3" href='pdf1.php?export=pdf'> <i class="fa-solid fa-print"></i>Export
                        to PDF</a>
                       

                    <!-- <a href="pdf.php?export=pdf" class="btn btn-success btn-block mt-3 mb-3" role="button"> <i
                            class="fa-solid fa-print"></i> Export
                        to PDF </a> -->

                    <?php
                include("connection1.php");

                $result = mysqli_query($conn, "SELECT * FROM visiting");

                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['fname']}</td>
                                <td>{$row['lname']}</td>
                                <td>{$row['cname']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['message']}</td>
                                <td>
                                    <a href='javascript:void(0)' class='btn btn-danger btn-sm mb-3 deletebtn' data-id='{$row['id']}'>Delete</a>
                                    <a href='updatemeb.php?id={$row['id']}' class='btn btn-warning btn-sm mb-3'>Update</a>
                                    <a class='btn btn-primary mb-3' href='sendvisitingcard.php?id={$row['id']}'>SendVisiting</a>
                                    <a class='btn btn-success mb-3' href='sendletterhead.php?id={$row['id']}' target='_blank'>SendLetterHead</a>
                                </td>
                              </tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p>No records found</p>";
                }

                mysqli_close($conn);
                ?>
                    <a href="display.php">Back</a>

                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.deletebtn').on('click', function() {
            var id = $(this).data('id');

            if (confirm("Are you sure you want to delete this record?")) {
                $.ajax({
                    url: 'deletemem.php',
                    type: 'POST',
                    data: {
                        user_id: id
                    },
                    success: function(response) {
                        if (response === 'success') {
                            location.reload();
                        } else {
                            alert("Error: " + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error while deleting data: " + error);
                    }
                });
            } else {
                // Code to handle cancel action
            }
        });
    });
    </script>
</body>

</html>