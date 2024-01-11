<?php
include("connection1.php");



$resul = array();

if (isset($_GET['id'])) {
    $editId = $_GET['id'];
    $sql = "SELECT * FROM visiting WHERE id='$editId'";
    $data = mysqli_query($conn, $sql);
    $resul = mysqli_fetch_assoc($data);
}
else{
    echo "id is not set";
}

if (isset($_POST['updateData'])) {
    $idToUpdate = $resul['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $cname = $_POST['cname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $updateQuery = "UPDATE visiting SET fname='$fname', lname='$lname', cname='$cname', address='$address', email='$email', phone='$phone', message='$message' WHERE id=$idToUpdate";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Record updated successfully!";
        header("Location: displaymeb.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
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
                                                <input type="text" name="fname" id="form6Example1" class="form-control"
                                                    value="<?php echo isset($resul['fname']) ? $resul['fname'] : ''; ?>" />
                                                <label class="form-label" for="form6Example1">First name</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" name="lname" id="form6Example2" class="form-control"
                                                    value="<?php echo isset($resul['lname']) ? $resul['lname'] : ''; ?>" />
                                                <label class="form-label" for="form6Example2">Last name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="cname" id="form6Example3" class="form-control"
                                            value="<?php echo isset($resul['cname']) ? $resul['cname'] : ''; ?>" />
                                        <label class="form-label" for="form6Example3">Company name</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="address" id="form6Example4" class="form-control"
                                            value="<?php echo isset($resul['address']) ? $resul['address'] : ''; ?>" />
                                        <label class="form-label" for="form6Example4">Address</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="email" name="email" id="form6Example5" class="form-control"
                                            value="<?php echo isset($resul['email']) ? $resul['email'] : ''; ?>" />
                                        <label class="form-label" for="form6Example5">Email</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="phone" id="form6Example6" class="form-control"
                                            value="<?php echo isset($resul['phone']) ? $resul['phone'] : ''; ?>" />
                                        <label class="form-label" for="form6Example6">Phone</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <textarea class="form-control" name="message" id="form6Example7" rows="4">
                                        <?php echo isset($resul['message']) ? $resul['message'] : ''; ?>
                                    </textarea>
                                        <label class="form-label" for="form6Example7">Additional information</label>
                                    </div>

                                    <input type="submit" name="updateData" class="btn btn-primary btn-block"
                                        value="Update visiting card">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>