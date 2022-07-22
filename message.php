<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    echo "<!DOCTYPE html>
          <html>";
    echo "<head>        <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script></head>";
    echo "<body onload=\"autoref()\">";
    require('topNav.php');

    echo "<div class=\"gapTop\"></div>";
    $senderID = $_SESSION['id'];

    $messageID = $_POST['messageID'];

    echo "<img src=\"users/$messageID/profile\" alt=\"Profile image\" style=\"width:150px;height:150px;border-radius:50%; display: block; margin-left: auto;
    margin-right: auto;\">";

    $safe_value = mysqli_real_escape_string($con, $messageID);

    $result = mysqli_query($con, "SELECT username, id, fname, lname FROM accounts WHERE `id` = '$safe_value'");

    $recieveID;

    while ($row = mysqli_fetch_assoc($result)) {
        echo"<h2 style=\"margin-left: auto; margin-right: auto; width: 300px; margin-bottom: 1%; font-family: Arial;\"> ".$row['fname']. " ".$row['lname']." </h2>";
        $recieveID = $row['id'];

    }

    echo"<div id=\"responsecontainer\" style=\"\"></div>";


    echo"
        <form action=\"\" style=\"margin-left: auto; margin-right: auto; width: 300px; clear:both; padding-top: 2%;\" >
        <input type=\"text\" id=\"sendmessage\" name=\"sendmessage\" placeholder=\"Message...\">
        <input type=\"hidden\" value=\"".$senderID."\" name=\"sendID\" id=\"sendID\" />
        <input type=\"hidden\" value=\"".$recieveID."\" name=\"recieveID\" id=\"recieveID\"/>
        <input type=\"submit\" value=\"Send\">
        </form>

    ";


    echo "

    <script>
    $(document).ready(function () {
        $(\"form\").submit(function (event) {
            var sendID = $(\"#sendID\").val();
            var recieveID = $(\"#recieveID\").val();
            var sendmessage = $(\"#sendmessage\").val();
            document.getElementById('sendmessage').value = \"\";
          $.ajax({
            type: \"POST\",
            url: \"sendmessage.php\",
            data: { sendID: sendID, recieveID: recieveID, sendmessage: sendmessage },            
            dataType: \"string\",
          }).done(function (data) {
          });
      
          event.preventDefault();
        });
      });
      

    </script>

    
    ";
    echo"
    <script>
    var prevRowcount = 0;
     function autoref() {
        var sendID = $(\"#sendID\").val();
              var recieveID = $(\"#recieveID\").val();         
               $.ajax({    
                 type: \"POST\",
                 url: \"displaymessages.php\",       
                 data: { sendID: sendID, recieveID: recieveID},      
                 dataType: \"html\",   //expect html to be returned                
                 success: function(response){                    
                     $(\"#responsecontainer\").html(response); 
                     //alert(response);
                 }
         
             });
             box = document.getElementById('responsecontainer');
             var rowCount = box.getElementsByTagName('*').length;
             console.log(rowCount);
             if(rowCount > prevRowcount){
                $('#responsecontainer').scrollTop($('#responsecontainer')[0].scrollHeight);
                prevRowcount = rowCount;
             }
      };
      setInterval(autoref, 1000);//1000 is miliseconds
   
   </script>
    ";
    echo "</body>";
    echo "</html>";

}else{

    header("Location: index.php");

    exit();

}

 ?>