<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $postID = $_POST['postID'];
    $likerID = $_POST['likerID'];
    $datetime = date("Y-m-d H:i:s");

    $query1    = "SELECT * FROM likes WHERE postID = '$postID' AND userID = '$likerID'";
    $result1   = mysqli_query($con, $query1);

    if(mysqli_num_rows($result1) < 1){
        $query    = "INSERT into `likes` (postID, userID, likeTime)
                        VALUES ('$postID', '$likerID', '$datetime')";
        $result   = mysqli_query($con, $query);
        $id = $_SESSION['id'];
        $likeString = file_get_contents("users/".$id."/likes.txt");
    
        $count = 0;
        $str_arr = [strlen($likeString)];
        for($x=0;$x<strlen($likeString);$x++){
            if($likeString[$x] !== ','){
                $count++;
            }
            if($count > 0){
                break;
            }
        }
        $file = fopen("users/".$id."/likes.txt", "a");
        if($count > 0){
            fwrite( $file,  ",");
        }
        fwrite( $file,  $postID);

    } else {
        $query    = "DELETE FROM likes WHERE postID = '$postID' AND userID = '$likerID'";
        $result   = mysqli_query($con, $query);
        
            }
    
        
    
}else{

    header("Location: index.php");

    exit();

}

 ?>