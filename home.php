<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    echo"<head><link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script></head>";
    require('topNav.php');
    
    $id = $_SESSION['id'];


    $file = fopen("users/$id/following.txt", "r");
    $string = fread($file,filesize("users/$id/following.txt"));
    fclose($file);
    $count = 0;
    $str_arr = [strlen($string)];
    
    for($x=0;$x<strlen($string);$x++){
        if($string[$x] !== ','){
            $str_arr[$count] = $string[$x];
            $count++;
        }
    }
    $string = "'";
    for($x=0;$x<$count;$x++){
        $string .= $str_arr[$x];
        if($x<$count-1){
            $string .= "','";
        }
    }
    $string .= "'";

    


    $sql = "SELECT id, userID, mediaPath, postText, timePosted FROM posts WHERE userID IN ($string) OR userID = '$id' ORDER BY timePosted DESC";
    $selectresult = $con->query($sql);


    echo"<div style=\"width: 30%; margin-top: 5%; margin-left: auto; margin-right: auto;\">";
    while($posts = mysqli_fetch_assoc($selectresult)){
        $userID = $posts["userID"];
        $sql2 = "SELECT username FROM accounts WHERE id = $userID";
        $result = $con->query($sql2);
        $username = "";
        $liked = false;
        while($usernames = mysqli_fetch_assoc($result)){
            $username = $usernames["username"];
        }
        
        $postID2 = $posts["id"];
        $sql3 = "SELECT * FROM likes WHERE userID = $id AND postID = $postID2";
        $result3 = $con->query($sql3);
        $likedata = mysqli_num_rows($result3);
        if($likedata > 0){
            $liked = true;
            /*echo"console.log(Liked photo ".$userID." ".$postID2." ".$likedata.")";*/

        }
        $sql4 = "SELECT * FROM likes WHERE postID = $postID2";
        $result4 = $con->query($sql4);
        $numoflikes = mysqli_num_rows($result4);
        



    $path = $posts["mediaPath"];
    $text = $posts["postText"];
    $time = $posts["timePosted"];
    $postID = $posts["id"];
    $likerID = $_SESSION['id'];
    


    echo"
        <div style=\"background-color: lightgray;\">
            <a href=\"user.php?id=$userID\" class=\"postsUsernameDisplay\">$username</a>
            <img src=\"$path\"  style=\"width:100%;aspect-ratio : 1 / 1;\">
            <div style=\"width: 80%; display: inline-block;\">
            <p>$text</p>
            <p>$time</p>
            <a href=\"likes.php?id=$postID\" class=\"likesDisplay\">$numoflikes likes</a>
            </div>
            ";
    if($liked === true){
        echo"<input type=\"image\" style=\"width:30px;height:30px\" onclick=\"likePost($postID,$likerID)\" src=\"likeheart.png\" />";
    } else {
        echo"<input type=\"image\" style=\"width:30px;height:30px\" onclick=\"likePost($postID,$likerID)\" src=\"heart.png\" />";
    }


    echo"
        </div>
        <br>
    ";
    }
    echo"</div>";
    echo"
            <script>
            function likePost(postID, likerID) {
                console.log(postID + \" \" + likerID);
                var postID = postID;
                var likerID = likerID;
                $.ajax({
                    type: \"POST\",
                    url: \"likePost.php\",
                    data: { postID: postID, likerID: likerID},            
                    dataType: \"string\",
                  });
            }
        </script>
    
    ";


}else{

    header("Location: index.php");

    exit();

}

 ?>