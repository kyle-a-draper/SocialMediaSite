<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $messageText = $_POST['sendmessage'];
    $sendID = $_POST['sendID'];
    $recieveID = $_POST['recieveID'];

    $message_datetime = date("Y-m-d H:i:s");
        $query    = "INSERT into `messages` (sent_from, sent_to, message_content, time_sent)
                     VALUES ('$sendID', '$recieveID', '$messageText', '$message_datetime')";
        $result   = mysqli_query($con, $query);
}else{

    header("Location: index.php");

    exit();

}

 ?>