<?php
include('connection.php');


    $senderID = $_POST['sendID'];

    $recieveID = $_POST['recieveID'];

    $safe_value1 = mysqli_real_escape_string($con, $senderID);
    $safe_value2 = mysqli_real_escape_string($con, $recieveID);

    $result = mysqli_query($con, "SELECT message_id, message_content, time_sent, sent_from FROM messages WHERE (`sent_from` = '$safe_value1' AND `sent_to` = '$safe_value2') OR (`sent_from` = '$safe_value2' AND `sent_to` = '$safe_value1') ");
    echo "<div id=\"#chatTable\">";
while($row = mysqli_fetch_assoc($result))
{   
    if($safe_value1 === $row['sent_from']){
        echo "<p style=\"font-family: Arial; clear: both; word-wrap: break-word; overflow-x: hidden; float: right; padding-bottom: 2%; padding-top: 2%; padding-right: 3%; padding-left: 5%; margin-top: 5%; border-radius: 10px 0px 0px 10px; background-color: blue; color: white;\">".$row['message_content']."</p>
        <span =\"display: block; margin-bottom: -1%;\"></span>";
        echo "<p style=\"clear: both; overflow-x: hidden; float: right; margin-top: 0%; color: grey;\">".substr($row['time_sent'],10,-3)."</p><br>";
    }
    if($safe_value2 === $row['sent_from']){
        echo "<p style=\"font-family: Arial; clear: both; word-wrap: break-word; overflow-x: hidden; float: left; padding-bottom: 2%; padding-top: 2%; padding-right: 5%; padding-left: 3%; margin-top: 5%; border-radius: 0px 10px 10px 0px; background-color: green; color: white;\">".$row['message_content']."</p><br>";
        echo "<p style=\"clear: both; overflow-x: hidden; float: left; margin-top: 0%; color: grey;\">".substr($row['time_sent'],10,-3)."</p><br>";

    }
}
    echo "</div>"


 ?>