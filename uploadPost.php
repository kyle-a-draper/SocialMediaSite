<?php
require('connection.php');


session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

    $id = $_POST['userID'];
    $text = $_POST['postDescription'];

    $postDatetime = date("Y-m-d H:i:s");
    $query    = "INSERT into `posts` (userID, timePosted, postText)
                 VALUES ('$id', '$postDatetime', '$text')";
    $result   = mysqli_query($con, $query);

    $sql = "SELECT id FROM posts WHERE userID = '$id' AND timePosted = '$postDatetime' AND postText = '$text'";
    $selectresult = $con->query($sql);
    $accounts = $selectresult->fetch_assoc();
    if (mysqli_num_rows($selectresult) > 0){
        $postID = $accounts["id"];
        $target_dir = "users/".$id."/";
        $mediaPath = $target_dir.$postID;
        $query    = "UPDATE `posts` SET mediaPath = '$mediaPath' WHERE  id = '$postID'";
        $result   = mysqli_query($con, $query);

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
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $postID)) {
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