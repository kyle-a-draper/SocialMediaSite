<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    require('connection.php');

    require('topNav.php');
    $userID = $_SESSION['id'];
    echo "<!DOCTYPE html>
    <html>
    <head>
    <title>HOME</title>
    <link rel=\"stylesheet\" href=\"styles.css\">
    </head>
    <body>
";
    

    echo"
    <form action=\"uploadPost.php\" style=\"margin-top:5%\" method=\"post\" enctype=\"multipart/form-data\">

            <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">

            <input type=\"text\" id=\"postDescription\" name=\"postDescription\" placeholder=\"Description...\">

            <input type=\"hidden\" value=\"".$userID."\" name=\"userID\" id=\"userID\" />

            <input type=\"submit\" value=\"Submit\" name=\"submit\">
        </form>
    </div>";
    echo "
    </body>
    </html>
";



}else{
 
    header("Location: index.php");

    exit();

}

 ?>