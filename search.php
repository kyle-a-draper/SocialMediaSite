<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    echo "<!DOCTYPE html>
          <html>";
    echo "<head>        <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script></head>";
    echo "<body>";
    require('topNav.php');

    $safe_value = mysqli_real_escape_string($con, $_POST['search']);

    $result = mysqli_query($con, "SELECT id, username, fname, lname FROM accounts WHERE `username` LIKE '%$safe_value%'");
    echo"<div style=\"margin-top:8%;\">";
    echo "<table>";
    $id = $_SESSION['id'];

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td><img src=\"users/" . $row['id'] . "/profile\" alt=\"Profile image\" style=\"width:50px;height:50px;border-radius:50%;\">"
        . $row['fname'] . " " . $row['lname'];
        echo "<br><p class=\"usernameDisplay\">@" . $row['username']. "</p>";
        
        $followingbool = false;
        
        $sql3 = "SELECT * FROM follows WHERE followerID = $id AND followingID = ".$row['id'];
        $result3 = $con->query($sql3);
        $followdata = mysqli_num_rows($result3);
        if($followdata > 0){
            $followingbool = true;
            /*echo"console.log(Liked photo ".$userID." ".$postID2." ".$likedata.")";*/

        }
        
        if($followingbool){
            echo "<button type=\"button\" onclick=\"followUser(".$id.",".$row['id'].")\">Unfollow</button>
            ";
        }  
        else{
            echo "<button type=\"button\" onclick=\"followUser(".$id.",".$row['id'].")\">Follow</button>
            ";        }
        echo "</td></tr>";
         }
    echo "</table></div>";
    echo "</body>";
    echo "</html>";
    echo"
    <script>
    function followUser(followerID, followingID) {
        console.log(followerID + \" \" + followingID);
        var followerID = followerID;
        var followingID = followingID;
        $.ajax({
            type: \"POST\",
            url: \"follow.php\",
            data: { followerID: followerID, followingID: followingID},            
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