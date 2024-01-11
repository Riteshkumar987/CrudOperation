<?php
include("connection.php");

function checkemail($username)
{
    return preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $username);
}

if (isset($_POST['reg'])) {
    $username = $_POST['username'];
    $passwd = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $gender = $_POST['gen'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    if (isset($_POST['hobbies'])) {
        $hobbi = $_POST['hobbies'];
        $hobbies = serialize($hobbi);
    } else {
        $hobbies = null;
    }

    $targetDir = "uploadimage/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) 
            if ($country !== "Select-country" && $state != "Select-state" && $city != "Select-city") {
                if ($passwd == $cpassword) {
                    $password = md5($passwd);

                    $sql = "INSERT INTO student(username, password, firstname, lastname, gender, country, state, city, hobbies, image) 
                                VALUES ('$username', '$password', '$fname', '$lname', '$gender', '$country', '$state', '$city', '$hobbies', '$targetFilePath')";

                    if (mysqli_query($conn, $sql)) {
                        echo "<script>alert('Record inserted successfully.')</script>";
                        if(!isset($_SESSION['id']))
                        {
                            echo "<script>location.href='display.php';</script>";
                        }
                        if(!isset($_COOKIE['id']))
                        {
                            echo "<script>location.href='display.php';</script>";
                        }
                        echo "<script>location.href='login.php';</script>";
                    } else {
                        echo "Error: " . $sql . "</br>" . mysqli_error($conn);
                    }
                }
            } else {
                echo "<script>alert('Please select a valid country, state, and city.')</script>";
            }
        }
    } 
    

    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $gender = $_POST['gen'];
        $country = $_POST['country'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $hobbies = isset($_POST['hobbies']) ? serialize(explode(",", $_POST['hobbies'])) : serialize([]);
        
        $newimage = $_FILES['image']['name'];
        $oldimage = isset($_POST['current_image']) ? $_POST['current_image'] : '';
    
        $target = "uploadimage/";
        $timestamp = md5(time());
        $fileExtension = pathinfo($newimage, PATHINFO_EXTENSION);
        $targetFile = $target . basename($newimage, '.' . $fileExtension). $timestamp . '.' . $fileExtension;
    
        if ($newimage != '') {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
            $update = $newimage;
    
            if ($newimage !== '' && file_exists($oldimage) && !is_dir($oldimage)) {
                unlink($oldimage);
            }  
        } else {
            $update = $targetFile = $oldimage;
        }
    
        $queries = "UPDATE student SET firstname='$fname', lastname='$lname', gender='$gender', country='$country', state='$state', city='$city',hobbies='$hobbies', image='$targetFile' WHERE id='$id'";
    
        $res = mysqli_query($conn, $queries);
        if ($res) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }
    ?>
  