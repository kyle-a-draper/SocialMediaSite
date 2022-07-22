<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    require('connection.php');

    require('topNav.php');



    $id = $_GET['id'];






    echo "<!DOCTYPE html>
        <html>
        <head>
        <title>HOME</title>
        <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script>
        </head>
        <body>
    ";

    echo "<table style=\"margin-top:5%;\">";

    $sql = "SELECT userID FROM likes WHERE postID = $id ORDER BY likeTime DESC";
    $selectresult = $con->query($sql);
    while($likes = mysqli_fetch_assoc($selectresult)){
        $userID = $likes["userID"];
        $username = "";
        $sql1 = "SELECT username FROM accounts WHERE id = $userID";
        $selectresult1 = $con->query($sql1);
        while($results = mysqli_fetch_assoc($selectresult1)){
            $username = $results["username"];
        }
        echo "<tr><td><img src=\"users/" . $userID . "/profile\" alt=\"Profile image\" style=\"width:50px;height:50px;border-radius:50%;\">"
            .$username;
        echo "</td></tr>";

    
    }
    echo "</table>";


    
    echo "
    

    </body>

</html>";




}else{

    header("Location: index.php");

    exit();

}

 ?>