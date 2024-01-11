<?php
session_start();
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

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="\"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <li>
                        <a href="dashbord.php" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Home
                            </span></a>
                    </li>
                </div>
            </div>

            <div class="col py-3">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card bg-light text-dark">
                            <div class="card-body">
                                <form method="POST">
                                    <h2 class="text-center mb-3">Visiting Card</h2>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" name="fname" id="fname" class="form-control" />
                                                <label class="form-label" for="form6Example1">First name</label>
                                                <div id="fname-error" class="error-message"></div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" name="lname" id="lname" class="form-control" />
                                                <label class="form-label" for="form6Example2">Last name</label>
                                                <div id="lname-error" class="error-message"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="cname" id="cname" class="form-control" />
                                        <label class="form-label" for="form6Example3">Company name</label>
                                        <div id="cname-error" class="error-message"></div>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="address" id="address" class="form-control" />
                                        <label class="form-label" for="form6Example4">Address</label>
                                        <div id="address-error" class="error-message"></div>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="email" name="email" id="email" class="form-control" />
                                        <label class="form-label" for="form6Example5">Email</label>
                                        <div id="email-error" class="error-message"></div>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="phone" id="phone" class="form-control" />
                                        <label class="form-label" for="form6Example6">Phone</label>
                                        <div id="phone-error" class="error-message"></div>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <textarea class="form-control" name="message" id="message" rows="4"></textarea>
                                        <label class="form-label" for="form6Example7">Additional information</label>
                                        <div id="message-error" class="error-message"></div>
                                    </div>

                                    <div id="validation-messages" class="mb-3"></div>

                                    <input type="submit" onclick="checkuser()" name="register"
                                        class="btn btn-primary btn-block" value="Send visiting card" id="submit-btn">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("connection1.php");
 if (isset($_POST['register'])) {
            
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $cname = $_POST['cname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    echo $phone;
    $message = $_POST['message'];

    $sql = "INSERT INTO visiting (fname, lname, cname, address, email, phone, message) VALUES ('$fname', '$lname', '$cname', '$address', '$email', '$phone', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "Record inserted successfully!";
        $_SESSION['email']= $_POST['email'];
        echo "<script>location.href='displaymeb.php';</script>";
        
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

    <script>
    $(document).ready(function() {
        $("#submit-btn").click(function(e) {
            checkuser();
        });

        $("#fname, #lname, #cname, #address, #email, #phone, #message").on("keydown", function() {
            clearErrorAndStyling($(this), $("#" + $(this).attr("id") + "-error"));
        });

        $('#phone').on('input', function() {
            var inputValue = $(this).val().replace(/\D/g, '');
            var formattedValue = inputValue.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            $(this).val(formattedValue);
        });


    });

    function checkuser() {
        var fnameInput = $("#fname");
        var lnameInput = $("#lname");
        var cnameInput = $("#cname");
        var addressInput = $("#address");
        var emailInput = $("#email");
        var phoneInput = $("#phone");
        var messageInput = $("#message");

        var fnameError = $("#fname-error");
        var lnameError = $("#lname-error");
        var cnameError = $("#cname-error");
        var addressError = $("#address-error");
        var emailError = $("#email-error");
        var phoneError = $("#phone-error");
        var messageError = $("#message-error");

        var validationMessages = $("#validation-messages");

        fnameError.text("");
        lnameError.text("");
        cnameError.text("");
        addressError.text("");
        emailError.text("");
        phoneError.text("");
        messageError.text("");

        var isValid = true;

        if (fnameInput.val().length < 3) {
            fnameError.text("First name at least 3 characters");
            isValid = false;
            fnameInput.addClass("is-invalid");
        } else {
            fnameInput.removeClass("is-invalid");
        }

        if (lnameInput.val().length < 3) {
            lnameError.text("last name at least 3 characters");
            isValid = false;
            lnameInput.addClass("is-invalid");
        } else {
            lnameInput.removeClass("is-invalid");
        }

        if (cnameInput.val().length < 3) {
            cnameError.text("company name at least 3 characters");
            isValid = false;
            cnameInput.addClass("is-invalid");
        } else {
            cnameInput.removeClass("is-invalid");
        }

        if (addressInput.val().length < 3) {
            addressError.text("address at least 3 characters");
            isValid = false;
            addressInput.addClass("is-invalid");
        } else {
            addressInput.removeClass("is-invalid");
        }

        if (emailInput.val().length < 3) {
            emailError.text("email at least 3 characters");
            isValid = false;
            emailInput.addClass("is-invalid");
        } else {
            emailInput.removeClass("is-invalid");
        }
        var mobile = phoneInput.val();

        if (mobile.length !== 14 || !(/^\(\d{3}\) \d{3}-\d{4}$/.test(mobile))) {
            phoneError.text("Please enter a valid phone number");
            isValid = false;
            phoneInput.addClass("is-invalid");
        } else {
            phoneInput.removeClass("is-invalid");
        }

        if (messageInput.val().length < 3) {
            messageError.text("message at least 3 characters");
            isValid = false;
            messageInput.addClass("is-invalid");
        } else {
            messageInput.removeClass("is-invalid");
        }

        if (isValid) {
            $("form").submit();
        } else {
            validationMessages.text("Please fix the errors before submitting.");
        }
    }

    function clearErrorAndStyling(inputField, errorField) {
        errorField.text("");
        inputField.removeClass("is-invalid");
    }
    </script>

</body>

</html>