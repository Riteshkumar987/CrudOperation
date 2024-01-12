<?php
include("connection.php");
ob_start();
session_start();

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
<div class="modal fade" id="changeProfileImageModal" tabindex="-1" aria-labelledby="changeProfileImageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="changeProfileImageModalLabel">Change Profile Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <?php if (isset($resu['image'])): ?>
                <img src="<?php echo $resu['image']; ?>" alt="Profile Image" width="100" class="img-fluid rounded-circle"
                    style="object-fit: cover;">
                <?php endif; ?>
                <p class="mt-2 mb-0"><?php echo $resu['firstname'] . " " . $resu['lastname']; ?></p>

                <form action="upload_profile_image.php" method="post" enctype="multipart/form-data" class="mt-3">
                    <div class="mb-3">
                        <label for="newProfileImage" class="form-label">Choose new image:</label>
                        <input type="file" class="form-control" id="newProfileImage" name="newProfileImage" required>
                    </div>
                    <button type="submit" name="updateprofileimages"class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['updateprofileimages'])) {
    if (isset($_FILES["newProfileImage"]) && $_FILES["newProfileImage"]["error"] == 0) {
        $targetDir = "uploadimage/"; 
        $targetFile = $targetDir . basename($_FILES["newProfileImage"]["name"]);

        if (!file_exists($targetFile)) {
            move_uploaded_file($_FILES["newProfileImage"]["tmp_name"], $targetFile);
            header("Location: your_existing_file.php");
            exit();
        } else {
            echo "File already exists.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>