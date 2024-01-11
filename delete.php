<?php
session_start();
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Confirmation</title>
    </head>
    <body>
   
        <?php
        if ($id != $_SESSION['id'] && isset($_GET['id'])) {
           
            $sql = "DELETE FROM student WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>location.href='display.php';</script>";
            } else {
                echo "<script>alert('Record not deleted successfully')</script>";
            }
        } else {
            echo "<script>
            alert('Can not delete this user!');
            location.href='display.php';
            </script>";
        }
        ?>
    </body>
    </html>
<?php
} else {
    echo "<script>alert('Invalid ID')</script>";
}
?>
