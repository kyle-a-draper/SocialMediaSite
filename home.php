<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    echo"<head><link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script></head>";
    require('topNav.php');
    
    $id = $_SESSION['id'];

    $string = "";

    $string2 = "";


    $sql1 = "SELECT followingID FROM follows WHERE followerID = '$id'";
    $selectresult1 = $con->query($sql1);
    while($results = mysqli_fetch_assoc($selectresult1)){
        $string .= "'";
        $string .= $results["followingID"];
        $string .= "'";
        $string .= ",";


    }
    
    for($i = 0; $i < strlen($string)-1; $i++){
        $string2[$i] = $string[$i];
    }

    


    $sql = "SELECT id, userID, mediaPath, postText, timePosted FROM posts WHERE userID IN ($string2) OR userID = '$id' ORDER BY timePosted DESC";
    $selectresult = $con->query($sql);

    echo "<img src=\"messangeicon.png\" onclick=\"openChat(".$id.")\"  style=\"position: fixed; right: 2%; bottom: 2%; width:3%;aspect-ratio : 1 / 1;\">";


    echo"<div id=\"chatcontainer\"></div><div style=\"width: 30%; margin-top: 5%; margin-left: auto; margin-right: auto;\">";
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
        <div style=\"background-color: lightgray; padding: 2%;\">
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
    echo "
    <script>
    function openChat(userID) {
        var element = document.getElementById(\"chatcontainer\");
        element.style.visibility = \"visible\";
        console.log(\"visible\");
        visible = true;
        $.ajax({    
            type: \"POST\",
            url: \"messagesPopup.php\",       
            data: { userID: userID},      
            dataType: \"html\",   //expect html to be returned                
            success: function(response){                    
                $(\"#chatcontainer\").html(response); 
                //alert(response);
            }
    
        });
    };
        </script>
        ";


}else{

    header("Location: index.php");

    exit();

}

 ?>