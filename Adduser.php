<?php
include("connection.php");
session_start();
$editMode = false;
$passwordDisabled = '';
$cpasswordDisabled = '';
$captchaDisabled = '';

if (isset($_GET['id'])) {
    $editMode = true;
    $passwordDisabled = 'disabled';
    $cpasswordDisabled = 'disabled';
    $captchaDisabled = 'readonly';
}
$results = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM student WHERE id='$id'";
    $data = mysqli_query($conn, $sql);
    $results = mysqli_fetch_assoc($data);
  
}
$result = mysqli_query($conn, "SELECT * FROM countries");


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>

<body class="">
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar vh-100">
                <div class="sidebar-sticky h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="my-4 text-light">Admin Name</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active text-light" href="display.php">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="login.php">
                                    Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="#">
                                    Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Add any additional content you want below the navigation links -->
                </div>
            </nav>


            <main role="main" class="col-md-10 ml-sm-auto px-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"></h1>
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
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <li><a class="dropdown-item" href="#">Change Password</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card bg-light text-dark">
                                <div class="card-body">
                                    <form action="" class="rform" method="POST" id="registrationForm"
                                        enctype="multipart/form-data">
                                        <h2 class="text-center mb-3">New user</h2>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="username">Username <span
                                                            style="color: red;">*</span>:</label>
                                                    <div class="input-group">

                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="fas fa-envelope"></i></span>
                                                        </div>
                                                        <input type="email" class="form-control" id="username"
                                                            onInput="checkuser()" name="username" placeholder="Username"
                                                            value="<?php echo isset($results['username']) ? $results['username'] : ''; ?>">

                                                    </div>
                                                    <span id="check-username"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Password">Password <span
                                                            style="color: red;">*</span>:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="fa-solid fa-lock"></i></span>
                                                        </div>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password" placeholder="Password"
                                                            <?php echo $passwordDisabled; ?>>

                                                    </div>
                                                    <span id="check-password"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cPassword">Confirm Password <span
                                                            style="color: red;">*</span>:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="fa-solid fa-lock"></i></span>

                                                        </div>
                                                        <input type="password" name="cpassword" id="cpassword"
                                                            onInput="checkpass()" class="form-control"
                                                            placeholder="Re-type password"
                                                            <?php echo $cpasswordDisabled; ?> required>

                                                    </div>
                                                    <span id="check-cpassword"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fname">First Name <span
                                                            style="color: red;">*</span>:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="fa-solid fa-user"></i></span>
                                                        </div>
                                                        <input type="text" name="firstname" class="form-control"
                                                            placeholder="First name"
                                                            value="<?php echo isset($results['firstname']) ? $results['firstname'] : ''; ?>">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="lname">Last Name <span
                                                            style="color: red;">*</span>:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="fa-solid fa-user"></i></span>
                                                        </div>
                                                        <input type="text" name="lastname" class="form-control"
                                                            placeholder="Last name"
                                                            value="<?php echo isset($results['lastname']) ? $results['lastname'] : ''; ?>">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="gender">Gender<span
                                                                style="color: red;">*</span>:</label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="gen"
                                                                    id="male" value="Male"
                                                                    <?php echo (isset($results['gender']) && $results['gender'] == 'Male') ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="male">Male</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="gen"
                                                                    id="female" value="Female"
                                                                    <?php echo (isset($results['gender']) && $results['gender'] == 'Female') ? 'checked' : ''; ?>>
                                                                <label class="form-check-label"
                                                                    for="female">Female</label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="country">Country<span
                                                            style="color: red;">*</span>:</label>
                                                    <select name="country" class="form-control" id="country_dropdown"
                                                        required>
                                                        <option value="">Select-country</option>

                                                        <?php
                                       $country_result = mysqli_query($conn, "SELECT * FROM countries");
                                       while ($row = mysqli_fetch_assoc($country_result)) {
                                           $selected = (isset($results['country']) && $row['country_id'] == $results['country']) ? 'selected' : '';
                                           echo "<option value='{$row['country_id']}' {$selected}>{$row['country_name']}</option>";
                                       }
                                       ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="state">State<span style="color: red;">*</span>:</label>
                                                    <select name="state" class="form-control" id="state-dropdown">
                                                        <option value="">Select-state</option>
                                                        <?php
                                       if (isset($results['country'])) {
                                           $state_result = mysqli_query($conn, "SELECT * FROM states WHERE country_id = {$results['country']}");
                                           while ($row1 = mysqli_fetch_assoc($state_result)) {
                                               $selected = (isset($results['state']) && $row1['state_id'] == $results['state']) ? 'selected' : '';
                                               echo "<option value='{$row1['state_id']}' {$selected}>{$row1['state_name']}</option>";
                                           }
                                       }
                                       ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="city">City<span style="color: red;">*</span>:</label>
                                                    <select name="city" class="form-control" id="city-dropdown">
                                                        <option value="">Select-city</option>
                                                        <?php
                                    if(isset($results['state'])){
                                       $city_result = mysqli_query($conn, "SELECT * FROM cities WHERE state_id= {$results['state']}");
                                       while ($row2 = mysqli_fetch_assoc($city_result)) {
                                           $selected = (isset($results['city']) && $row2['city_id'] == $results['city']) ? 'selected' : '';
                                           echo "<option value='{$row2['city_id']}' {$selected}>{$row2['city_name']}</option>";
                                       }
                                    }
                                       ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="formFilesm" class="form-label">Upload Image<span
                                                            style="color: red;">*</span>:</label>
                                                    <input class="form-control" type="file" id="image" name="image">
                                                    <input type="hidden" name="current_image"
                                                        value="<?php echo isset($results['image']) ? $results['image'] : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <?php 
                                $chkbox = isset($results['hobbies']) ? $results['hobbies'] : '';
                                $arr = explode(",", $chkbox);

                            ?>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label>Hobbies:</label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="reding" type="checkbox"
                                                                <?php if (in_array("Reading", $arr)) echo "checked"; ?>
                                                                name="hobbies[]" value="Reading">
                                                            <label class="form-check-label" for="reding">Reading</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="trave" type="checkbox"
                                                                <?php if (in_array("Traveling", $arr)) echo "checked"; ?>
                                                                name="hobbies[]" value="Traveling">
                                                            <label class="form-check-label"
                                                                for="trave">Traveling</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="game" type="checkbox"
                                                                <?php if (in_array("Gaming", $arr)) echo "checked"; ?>
                                                                name="hobbies[]" value="Gaming">
                                                            <label class="form-check-label" for="game">Gaming</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>




                                        <input type="hidden" name="id"
                                            value="<?php echo isset($results['id']) ? $results['id'] : ''; ?>">
                                        <input type="submit" id="form" onclick="validate()" name=reg
                                            class="btn btn-primary btn-block" value="Add NewUser">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
    <?php
include("insert.php");

?>

    <script>
    function checkuser() {
        var usernameInput = $("#username");
        jQuery.ajax({
            url: "availity.php",
            data: 'username=' + $("#username").val(),
            type: "POST",
            success: function(data) {
                $("#check-username").html(data);
                if (data.indexOf('already registered') !== -1) {
                    usernameInput.css("border-color", "red");
                    $("#form").prop("disabled", true);
                } else {
                    usernameInput.css("border-color", "green");
                    $("#form").prop("disabled", false);
                }
            },
            error: function() {}
        });
    }

    function checkpass() {
        var passwordInput = $("#password");
        var confirmPasswordInput = $("#cpassword");

        jQuery.ajax({
            url: "password_check.php",
            data: {
                password: passwordInput.val(),
                cpassword: confirmPasswordInput.val()
            },
            type: "POST",
            success: function(data) {
                console.log()
                $("#check-password").html(data);
                $("#check-cpassword").html(data);
                if (data.indexOf('not') === 0) {
                    passwordInput.css("border-color", "red");
                    confirmPasswordInput.css("border-color", "red");

                } else {
                    passwordInput.css("border-color", "green");
                    confirmPasswordInput.css("border-color", "green");
                }
            },
            error: function() {}
        });
    }

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

    function validate() {
        var usernameValue = $('input[name="username"]').val().trim();
        var password = $('input[name="password"]').val().trim();
        var cpassword = $('input[name="cpassword"]').val().trim();
        var fname = $('input[name="firstname"]').val().trim();
        var lname = $('input[name="lastname"]').val().trim();
        var gender = $('input[name="gen"]:checked').val();
        var country = $('select[name="country"]').val();
        var state = $('select[name="state"]').val();
        var city = $('select[name="city"]').val();
        var hobbies = $('input[name="hobbies[]"]:checked').length > 0;

        if (usernameValue === '') {
            alert("Please enter your username");
            event.preventDefault();
        }

        var password = document.getElementsByName('password')[0].value;
        var passwordDisabled = document.getElementsByName('password')[0].disabled;

        if (
            !passwordDisabled === '' ||
            !cpasswordDisabled === '' ||
            fname === '' ||
            lname === '' ||
            gender === undefined ||
            country === '' || country === 'Select-country' ||
            state === '' || state === 'Select-state' ||
            city === '' || city === 'Select-city'
        ) {
            var emptyFields = [];

            if (!passwordDisabled === '') emptyFields.push('Password');
            if (!cpasswordDisabled === '') emptyFields.push('Confirm Password');
            if (fname === '') emptyFields.push('First Name');
            if (lname === '') emptyFields.push('Last Name');
            if (gender === undefined) emptyFields.push('Gender');
            if (country === '' || country === 'Select-country') emptyFields.push('Country');
            if (state === '' || state === 'Select-state') emptyFields.push('State');
            if (city === '' || city === 'Select-city') emptyFields.push('City');

            alert('Please fill out all required fields: ' + emptyFields.join(', '));
            event.preventDefault();
        }

        var cpassword = document.getElementsByName('cpassword')[0].value;
        var cpasswordDisabled = document.getElementsByName('cpassword')[0].disabled;

        var stg1 = document.getElementById('capt').value;
        var stg2 = document.getElementById('textinput').value;
        if (!captchaDisabled) {
            if (stg2 = '') {
                alert("pleas type your captcha");
            }
            if (stg1 != stg2) {
                alert('please enterrr your valid captcha');
                event.preventDefault();
                return false;
            }
        }
    }
    </script>


</body>

</html>