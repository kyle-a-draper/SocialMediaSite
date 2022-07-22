<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    echo "<!DOCTYPE html>
          <html>";
    echo "<head>        <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script></head>";
    echo "<body>";
    require('topNav.php');

    echo "</body>";
    echo "</html>";

}else{

    header("Location: index.php");

    exit();

}

 ?>