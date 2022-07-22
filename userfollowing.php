<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_GET['id'];
    $userID = $_SESSION['id'];
    $followersString = file_get_contents("users/".$id."/following.txt");
    $followersArr = explode(',', $followersString);
    $i = 0;
    echo "<table>";
    while($i < count($followersArr)){
    $safe_value = mysqli_real_escape_string($con, $followersArr[$i]);

    $result = mysqli_query($con, "SELECT id, username FROM accounts WHERE `id` = '$safe_value'");

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td><img src=\"users/" . $followersArr[$i] . "/profile\" alt=\"Profile image\" style=\"width:50px;height:50px;border-radius:50%;\">"
            . $row['username']
            ."<form action=\"message.php\" method=\"post\"><input type=\"hidden\" value=\"".$row['id']."\" name=\"messageID\" /><input type=\"submit\" name=\"message\" value=\"Message\" /></form></td></tr>";
    }
         $i++;
    }
    echo "</table>";

}else{

    header("Location: index.php");

    exit();

}

 ?>