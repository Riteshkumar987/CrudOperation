
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
