<?php
include('connection.php');

    echo"<div id=\"messagesContainer\" style=\"overflow-y:auto;\"></div>";

    $userID = $_POST['userID'];

    $result = mysqli_query($con,"SELECT DISTINCT sent_from, sent_to FROM messages WHERE sent_from = $userID or sent_to = $userID;");
    echo "<div id=\"#postDisplay\">";
    $chats = array();
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        if($userID != $row['sent_from']){
                $chats[$i] = $row['sent_from'];
                $i++;
        }
        if($userID != $row['sent_to']){
                $chats[$i] = $row['sent_to'];
                $i++;
        }
    }
    $chats2 = array();
    $i = 0;
    for($x = 0; $x < sizeof($chats); $x++){
        if(!in_array($chats[$x], $chats2)){
            $chats2[$i] = $chats[$x];
            $i++;
        }
    }
    $chatdate = array();
    for($x = 0; $x < sizeof($chats2); $x++){
        $result = mysqli_query($con,"SELECT time_sent FROM mydb.messages WHERE (sent_from = ".$chats2[$x]." AND sent_to = $userID) OR (sent_from = $userID AND sent_to = ".$chats2[$x].") ORDER BY time_sent DESC LIMIT 1");
        while($row = mysqli_fetch_assoc($result)){
            $chatdate[$x] = $row['time_sent'];
        }
    }
    $chatdate1 = $chatdate;
    sort($chatdate1);
    $chats3 = array();
    for($x = 0; $x < sizeof($chatdate1); $x++){
        for($y = 0; $y < sizeof($chatdate); $y++){
            if($chatdate1[$x] === $chatdate[$y]){
                $chats3[$x] = $chats2[$y];
            }
        }
    }
    $chats3 = array_reverse($chats3);

    echo"<img src=\"x.png\" onclick=\"closeChat()\" style=\"float:right;width:5%;aspect-ratio : 1 / 1;\">";
    echo"<div style=\"width: 100%; padding-top: 10%;\">";
    for($x = 0; $x < $i; $x++){
        echo"<div onclick=\"openMessages(".$userID.",".$chats3[$x].")\" style=\"width: 100%; height: 10%; background-color: white; padding-bottom: 2%;border-bottom:1px solid grey\">
        <img src=\"users/$chats3[$x]/profile\"style=\"border-radius: 50%; float: left; padding-top: 0.5%; padding-right: 2%; padding-left: 2%; width:15%;aspect-ratio : 1 / 1;\">";
        $result = mysqli_query($con,"SELECT fname, lname FROM accounts WHERE id = $chats3[$x]");
        while($row = mysqli_fetch_assoc($result)){
        echo"
            <p style=\"font-weight: bold; font-family: Arial; padding-left: 2%; padding-bottom: 0; margin: 0;\">".$row['fname']." ".$row['lname']."</p>";
        }
        $result = mysqli_query($con,"SELECT message_content, time_sent FROM messages WHERE sent_from = $chats3[$x] or sent_to = $chats3[$x] ORDER BY time_sent DESC LIMIT 1");
        while($row = mysqli_fetch_assoc($result)){
        echo"<p style=\"bottom: 0%; white-space: nowrap; text-overflow: clip; font-family: Arial; padding-left: 2%; padding-top: 0; margin: 0;\">".$row['message_content']."</p></div>";
        }
        

    }
    echo"</div>";
    echo "
    <script>
    function closeChat() {
        var element = document.getElementById(\"chatcontainer\");
        element.style.visibility = \"hidden\";
    }
        </script>
        ";
        echo"
    <script>
    var prevRowcount = 0;
     function openMessages(sendID, recieveID) {
        var element = document.getElementById(\"messagesContainer\");
        element.style.visibility = \"visible\";
        visible = true;
        var sendID = sendID;
              var recieveID = recieveID;         
               $.ajax({    
                 type: \"POST\",
                 url: \"displaymessages.php\",       
                 data: { sendID: sendID, recieveID: recieveID},      
                 dataType: \"html\",   //expect html to be returned                
                 success: function(response){                    
                     $(\"#messagesContainer\").html(response); 
                     //alert(response);
                 }
         
             });
             box = document.getElementById('messagesContainer');
             var rowCount = box.getElementsByTagName('*').length;
             if(rowCount > prevRowcount){
                $('messagesContainer').scrollTop($('messagesContainer')[0].scrollHeight);
                prevRowcount = rowCount;
             }
      };   
   </script>
    ";


 ?>