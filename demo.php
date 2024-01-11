<?php
include("connection.php");
ob_start();
session_start();
require('fpdf/fpdf.php');

if (isset($_GET['export']) && $_GET['export'] == 'pdf') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'display.php');
    $pdf->Output('display.pdf', 'D');
   
}
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigmWqe6BwsGA4lH8SDd6U49aaQ=="
        crossorigin="anonymous">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Dashboard</title>

</head>

<body class="bg-light">
    <div class="ml-5">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar vh-100%">
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

            <main role="main" class="col-md-10">
                <div class="container mt-5">

                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <a href="Adduser.php" class="btn btn-primary" role="button">Add user</a>

                        <h1 class="h2">Student Record</h1>

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
                                <li><a class="dropdown-item btn-outline-primary" href="logout.php">Logout</a></li>
                                <li><a class="dropdown-item" href="changepass.php">Change Password</a></li>
                            </ul>
                        </div>
                    </div>



                    <form method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="email" placeholder="filter by Username :" name="username"
                                    class="form-control" id="usernameinput" aria-describedby="emailHelp"
                                    value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gen" id="male"
                                                    value="Male"
                                                    <?php echo (isset($_GET['gen']) && $_GET['gen'] == 'Male') ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="male">Male</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gen" id="female"
                                                    value="Female"
                                                    <?php echo (isset($_GET['gen']) && $_GET['gen'] == 'Female') ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="female">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="country" class="form-control" id="country_dropdown">
                                        <option value="">Select-country</option>
                                        <?php
                                            $country_result = mysqli_query($conn, "SELECT * FROM countries");
                                            while ($row = mysqli_fetch_assoc($country_result)) {
                                                $selected = (isset($_GET['country']) && $_GET['country'] == $row['country_id']) ? 'selected' : '';
                                              echo "<option value='{$row['country_id']}' {$selected}>{$row['country_name']}</option>";
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="state" class="form-control" id="state-dropdown">
                                        <option value="">Select-state</option>
                                        <?php
                                         if (isset($_GET['country'])) {
                                            $selectedCountry = mysqli_real_escape_string($conn, $_GET['country']);
                                            $state_result = mysqli_query($conn, "SELECT * FROM states WHERE country_id = '$selectedCountry'");
                                            while ($row1 = mysqli_fetch_assoc($state_result)) {
                                                $selected = (isset($_GET['state']) && $_GET['state'] == $row1['state_id']) ? 'selected' : '';
                                                echo "<option value='{$row1['state_id']}' {$selected}>{$row1['state_name']}</option>";
                                            }
                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="city" class="form-control" id="city-dropdown">
                                        <option value="">Select-city</option>
                                        <?php
                                        if (isset($_GET['state'])) {
                                            $selectedstate = mysqli_real_escape_string($conn, $_GET['state']);
                                            $query = "SELECT * FROM cities WHERE state_id= '$selectedstate'";
                                            
                                            $city_result = mysqli_query($conn, $query);

                                            while ($row2 = mysqli_fetch_assoc($city_result)) {
                                                $selected = (isset($_GET['city']) && $_GET['city'] == $row2['city_id']) ? 'selected' : '';
                                                echo "<option value='{$row2['city_id']}' {$selected}>{$row2['city_name']}</option>";
                                            }
                                        } 
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="submit" id="filter" name="filter" class="btn btn-secondary btn-block mt-3 mb-3"
                            value="Filter user">
                        <a href="display.php" class="btn btn-secondary btn-block mt-3 mb-3" role="button">Reset</a>
                        <a href="excels.php?export=excel" class="btn btn-success btn-block mt-3 mb-3" role="button"> <i
                                class="fa-solid fa-file-excel"></i> Export
                            to Excel</a>
                        <a href="pdf.php?export=pdf" class="btn btn-success btn-block mt-3 mb-3" role="button"> <i
                                class="fa-solid fa-print"></i> Export
                            to PDF </a>


                    </form>

                    <table class=" table table-bordered text-align-left bg-light text-dark">

                        <thead>
                            <tr>
                                <th>
                                    <form method="get" action="display.php">
                                        <input type="hidden" name="orderBy" value="username">
                                        <?php foreach ($_GET as $key => $value): ?>
                                        <?php if (!in_array($key, ['orderBy', 'sortOrder'])): ?>
                                        <input type="hidden" name="<?= htmlspecialchars($key) ?>"
                                            value="<?= htmlspecialchars($value) ?>">
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <button type="submit" class="btn sort-button" name="sortOrder"
                                            value="<?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? 'desc' : 'asc' ?>">
                                            Username
                                            <?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' ?>
                                        </button>
                                    </form>
                                </th>

                                <th>
                                    <form method="get" action="display.php">
                                        <input type="hidden" name="orderBy" value="firstname">
                                        <?php foreach ($_GET as $key => $value): ?>
                                        <?php if (!in_array($key, ['orderBy', 'sortOrder'])): ?>
                                        <input type="hidden" name="<?= htmlspecialchars($key) ?>"
                                            value="<?= htmlspecialchars($value) ?>">
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <button type="submit" class="btn sort-button" name="sortOrder"
                                            value="<?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? 'desc' : 'asc' ?>">
                                            FirstName
                                            <?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' ?>
                                        </button>
                                    </form>
                                </th>
                                <th>
                                    <form method="get" action="display.php">
                                        <input type="hidden" name="orderBy" value="lastname">
                                        <?php foreach ($_GET as $key => $value): ?>
                                        <?php if (!in_array($key, ['orderBy', 'sortOrder'])): ?>
                                        <input type="hidden" name="<?= htmlspecialchars($key) ?>"
                                            value="<?= htmlspecialchars($value) ?>">
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <button type="submit" class="btn sort-button" name="sortOrder"
                                            value="<?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? 'desc' : 'asc' ?>">
                                            Lastname
                                            <?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' ?>
                                        </button>
                                    </form>
                                </th>
                                <th>
                                    <form method="get" action="display.php">
                                        <input type="hidden" name="orderBy" value="gender">
                                        <?php foreach ($_GET as $key => $value): ?>
                                        <?php if (!in_array($key, ['orderBy', 'sortOrder'])): ?>
                                        <input type="hidden" name="<?= htmlspecialchars($key) ?>"
                                            value="<?= htmlspecialchars($value) ?>">
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <button type="submit" class="btn sort-button" name="sortOrder"
                                            value="<?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? 'desc' : 'asc' ?>">
                                            Gender
                                            <?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' ?>
                                        </button>
                                    </form>
                                </th>
                                <th>
                                    <form method="get" action="display.php">
                                        <input type="hidden" name="orderBy" value="country">
                                        <?php foreach ($_GET as $key => $value): ?>
                                        <?php if (!in_array($key, ['orderBy', 'sortOrder'])): ?>
                                        <input type="hidden" name="<?= htmlspecialchars($key) ?>"
                                            value="<?= htmlspecialchars($value) ?>">
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <button type="submit" class="btn sort-button" name="sortOrder"
                                            value="<?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? 'desc' : 'asc' ?>">
                                            Country
                                            <?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' ?>
                                        </button>
                                    </form>
                                </th>

                                <th>
                                    <form method="get" action="display.php">
                                        <input type="hidden" name="orderBy" value="state">
                                        <?php foreach ($_GET as $key => $value): ?>
                                        <?php if (!in_array($key, ['orderBy', 'sortOrder'])): ?>
                                        <input type="hidden" name="<?= htmlspecialchars($key) ?>"
                                            value="<?= htmlspecialchars($value) ?>">
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <button type="submit" class="btn sort-button" name="sortOrder"
                                            value="<?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? 'desc' : 'asc' ?>">
                                            State
                                            <?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' ?>
                                        </button>
                                    </form>
                                </th>
                                <th>
                                    <form method="get" action="display.php">
                                        <input type="hidden" name="orderBy" value="city">
                                        <?php foreach ($_GET as $key => $value): ?>
                                        <?php if (!in_array($key, ['orderBy', 'sortOrder'])): ?>
                                        <input type="hidden" name="<?= htmlspecialchars($key) ?>"
                                            value="<?= htmlspecialchars($value) ?>">
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <button type="submit" class="btn sort-button" name="sortOrder"
                                            value="<?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? 'desc' : 'asc' ?>">
                                            City
                                            <?= isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'asc' ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>' ?>
                                        </button>
                                    </form>
                                </th>


                                <th>Hobbies</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                 
               
                
                
                        include("connection.php");
                        $gender = '';
                            $username = '';
                            $country = '';
                            $state = '';
                            $city = '';
                            $orderClause='';
                            if (isset($_GET['filter'])) {
                                $username = mysqli_real_escape_string($conn, $_GET['username']);
                                
                                if (isset($_GET['gen'])) {
                                    $gender = mysqli_real_escape_string($conn, $_GET['gen']);
                                }
                                
                                $country = mysqli_real_escape_string($conn, $_GET['country']);
                                $state = mysqli_real_escape_string($conn, $_GET['state']);
                                $city = mysqli_real_escape_string($conn, $_GET['city']);
                            }
                           
                            $sql = "SELECT student.*, countries.country_name, states.state_name, cities.city_name
                            FROM student
                            LEFT JOIN countries ON student.country = countries.country_id
                            LEFT JOIN states ON student.state = states.state_id
                            LEFT JOIN cities ON student.city = cities.city_id
                            WHERE student.id != '$id'";
                            
                            if (!empty($username)) {
                                if (strpos($sql, 'WHERE') === false) {
                                    $sql .= " WHERE username LIKE '%$username%'";
                                } else {
                                    $sql .= " AND username LIKE '%$username%'";
                                }
                            }
 
                            if (!empty($gender)) {
                                $sql .= " AND gender = '$gender'";
                            }

                            if (!empty($country)) {
                                $sql .= " AND country = '$country'";
                            }

                            if (!empty($state)) {
                                $sql .= " AND state = '$state'";
                            }

                            if (!empty($city)) {
                                $sql .= " AND city = '$city'";
                            }
                         

                            if (isset($_GET['sortOrder']) && isset($_GET['orderBy'])) {
                                $orderBy = $_GET['orderBy'];
                                $sortOrder = $_GET['sortOrder'];

                                if ($sortOrder === 'asc' || $sortOrder === 'desc') {
                                    switch ($orderBy) {
                                        case 'country':
                                            $sql .= " ORDER BY countries.country_name $sortOrder";
                                            break;
                                        case 'state':
                                            $sql .= " ORDER BY states.state_name $sortOrder";
                                            break;
                                        case 'city':
                                            $sql .= " ORDER BY cities.city_name $sortOrder";
                                            break;
                                        default:
                                            $sql .= " ORDER BY student.$orderBy $sortOrder";
                                            break;
                                    }
                                }
                            }

                            
                           
                            $data = mysqli_query($conn, $sql);
                            $total=mysqli_num_rows($data);
                           
                            
                        $html = "";
                        if ($total != 0) {
                            while ($result = mysqli_fetch_assoc($data)) {
                                $country = "SELECT country_name FROM countries WHERE country_id={$result['country']}";
                                $countr = mysqli_query($conn, $country);
                                $c = mysqli_fetch_assoc($countr);
                                $imageURL = $result["image"];
                                $state = "SELECT state_name FROM states WHERE state_id={$result['state']}";
                                $stat = mysqli_query($conn, $state);
                                $s = mysqli_fetch_assoc($stat);
                                $cty = "SELECT city_name FROM cities WHERE city_id={$result['city']}";
                                $coun = mysqli_query($conn, $cty);
                                $ci = mysqli_fetch_assoc($coun);
                                $html .= "<tr>
                                    <td>" . $result['username'] . "</td>
                                    <td>" . $result['firstname'] . "</td>
                                    <td>" . $result['lastname'] . "</td>
                                    <td>" . $result['gender'] . "</td>
                                    <td>" . $c['country_name'] . "</td>
                                    <td>" . $s['state_name'] . "</td>
                                    <td>" . $ci['city_name'] . "</td>";
                                    $html .= "<td>";
                                        $hobbies = unserialize($result['hobbies']);
                                        
                                        if ($hobbies !== false && is_array($hobbies)) {
                                            foreach ($hobbies as $hobby) {
                                                if ($hobby != '') {
                                                    $html .= "<li>".$hobby."</li>";
                                                }
                                            }
                                        } 
                                        $html .= "</td>";
                                    $html .= "<td><img src='" . $imageURL . "' alt='' height='100' width='100'
                                            class='img-thumbnail' /></td>
                                    <td>
                                        <button type='button' class='btn btn-primary edit-btn'' data-id=".$result['id']."
                                            data-bs-toggle='modal' data-bs-target='#exampleModal'>edit</button>
                                        <button type='button' class='btn btn-danger delete-btn'
                                            data-id=".$result['id'].">Delete</button>
                                    </td>
                                </tr>" ;
                            }
                        echo $html;
                        }
                        else
                        {
                            echo '<tr>
                                <td colspan="10" class="text-center ">No Record found</td>
                            </tr>';

                        }
                        ob_end_flush();
                    ?>
                        </tbody>
                    </table>
            </main>



            <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> -->

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">User</h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="edit-content">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveChangesBtn" name="edit" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#country_dropdown').on('change', function() {
            var country_id = this.value;
            $.ajax({
                url: "state.php",
                type: "POST",
                data: {
                    country_data: country_id
                },
                success: function(result) {
                    $("#state-dropdown").html(result);


                }
            });
        });

        $('#state-dropdown').on('change', function() {
            var state_id = this.value;
            $.ajax({
                url: "city.php",
                type: "POST",
                data: {
                    state_data: state_id
                },
                success: function(result) {
                    $("#city-dropdown").html(result);

                }
            });
        });
    });


    $(document).ready(function() {
        $('.edit-btn').on('click', function() {
            var editId = $(this).data('id');
            $('#exampleModal').modal('show');
            console.log(editId);
            $.ajax({
                type: "POST",
                url: "fetch_data.php",
                data: {
                    id: editId
                },
                success: function(response) {
                    $('#edit-content').html(response);
                }
            });
        });

        $('#saveChangesBtn').on('click', function() {
            updateData();
        });

        $('.delete-btn').click(function() {
            let userId = $(this).data('id');
            let confirmDelete = confirm('are you sure?');
            if (confirmDelete) {
                window.location.href = 'delete.php?id=' + userId;
            }
        });

        function updateData() {
            var editId = $('#user_id').val();
            var firstName = $('input[name="firstname"]').val().trim();
            var lastName = $('input[name="lastname"]').val().trim();
            var gender = $('input[name="gen"]:checked').val();
            var country = $('select[name="country"]').val();
            var state = $('select[name="state"]').val();
            var city = $('select[name="city"]').val();

            var hobbies = $('input[name="hobbies[]"]:checked').map(function() {
                return this.value;
            }).get();

            var formData = new FormData($('#updateForm')[0]);
            formData.append('id', editId);
            formData.append('edit', true);
            formData.append('hobbies', hobbies.join(','));

            $.ajax({
                type: "POST",
                url: "insert.php",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Record Updated successfully');
                        $('#exampleModal').modal('hide');
                        location.reload();
                    }
                }
            });
        }
    });
    </script>
</body>

</html>