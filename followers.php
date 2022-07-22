<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $followersString = file_get_contents("users/".$id."/followers.txt");
    $followersArr = explode(',', $followersString);

    $followingString = file_get_contents("users/".$id."/following.txt");

    $followingArr = explode(',', $followingString);

    $i = 0;
    require('topNav.php');
    echo "<!DOCTYPE html>
    <html>
    <head>
    <title>HOME</title>
    <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script>
    </head>
    <body>
";

    echo "<table style=\"margin-top:5%;\">";
    while($i < count($followersArr)){
    $safe_value = mysqli_real_escape_string($con, $followersArr[$i]);

    $result = mysqli_query($con, "SELECT username, id FROM accounts WHERE `id` = '$safe_value'");

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td><img src=\"users/" . $followersArr[$i] . "/profile\" alt=\"Profile image\" style=\"width:50px;height:50px;border-radius:50%;\">"
            . $row['username'];
            $x = 0;
            $followingbool = false;
    
            for($x;$x < count($followingArr);$x++){
                if(intval($followingArr[$x]) === intval($row['id'])){
                    $followingbool = true;
                    break;
                }
            }
            if($followingbool){
                echo "<form action=\"unfollow.php\" method=\"post\"><input type=\"hidden\" value=\"".$row['id']."\" name=\"unfollow\" /><input type=\"submit\" name=\"unfollowbtn\" value=\"Unfollow\" /></form>";
            }  
            else{
                echo "<form action=\"follow.php\" method=\"post\"><input type=\"hidden\" value=\"".$row['id']."\" name=\"follow\" /><input type=\"submit\" name=\"followbtn\" value=\"Follow\" /></form>";
            }
            echo "</td></tr>";
    }

         $i++;
    }
    echo "</table>";
    echo "
    </body>
    </html>
";

}else{

    header("Location: index.php");

    exit();

}

 ?>