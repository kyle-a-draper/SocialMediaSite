<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $followerID = $_POST['followerID'];
    $followingID = $_POST['followingID'];
    $datetime = date("Y-m-d H:i:s");

    $query1    = "SELECT * FROM follows WHERE followerID = '$followerID' AND followingID = '$followingID'";
    $result1   = mysqli_query($con, $query1);

    if(mysqli_num_rows($result1) < 1){
        $query    = "INSERT into `follows` (followerID, followingID, timeFollowed)
                        VALUES ('$followerID', '$followingID', '$datetime')";
        $result   = mysqli_query($con, $query);
        $id = $_SESSION['id'];

    } else {
        $query    = "DELETE FROM follows WHERE followerID = '$followerID' AND followingID = '$followingID'";
        $result   = mysqli_query($con, $query);
        
            }
    
        
    
}else{

    header("Location: index.php");

    exit();

}

 ?>