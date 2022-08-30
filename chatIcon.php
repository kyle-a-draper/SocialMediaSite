<?php
    echo "<img src=\"messangeicon.png\" onclick=\"openChat(".$_SESSION['id'].")\"  style=\"position: fixed; right: 2%; bottom: 2%; width:3%;aspect-ratio : 1 / 1;\">";


    echo"<div id=\"chatcontainer\"></div>";

    echo "
    <script>
    function openChat(userID) {
        var element = document.getElementById(\"chatcontainer\");
        element.style.visibility = \"visible\";
        console.log(\"visible\");
        visible = true;
        $.ajax({    
            type: \"POST\",
            url: \"messagesPopup.php\",       
            data: { userID: userID},      
            dataType: \"html\",   //expect html to be returned                
            success: function(response){                    
                $(\"#chatcontainer\").html(response); 
                //alert(response);
            }

        });
    };
        </script>
        ";
?>