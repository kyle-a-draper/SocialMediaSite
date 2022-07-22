<?php
require('connection.php');


session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM accounts WHERE username = '$username'";
    $selectresult = $con->query($sql);
    $accounts = $selectresult->fetch_assoc();
    
    if (mysqli_num_rows($selectresult) > 0){
        $id = $accounts["id"];
        $target_dir = "users/".$id."/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        }
        if ($_FILES["fileToUpload"]["size"] > 500000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
          } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . "profile")) {
              echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            } else {
              echo "Sorry, there was an error uploading your file.";
            }
        }
          
}
header("Location: profile.php");
} else {
    header("Location: index.php");
}
?>