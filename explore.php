<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    echo "<!DOCTYPE html>
          <html>";
    echo "<head>        <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script></head>";
    echo "<body>";
    require('topNav.php');
    require('chatIcon.php');
    echo "<div id=\"postcontainer\"></div>";

    $sql = "SELECT posts.id, userID, mediaPath, accounts.private, accounts.username
    FROM posts
    INNER JOIN accounts ON accounts.id=userID
    WHERE accounts.private = 0
    ORDER BY RAND()
    LIMIT 30";
    $selectresult = $con->query($sql);
    echo "<div id=\"postcontainer\"></div><div style=\" z-index: 1; margin-top: 5%; width: 80%; margin-left: auto; margin-right: auto;\">";
    echo "
    <div style=\display: flex;
    flex-wrap: wrap;\">";
    while($posts = mysqli_fetch_assoc($selectresult)){
        $path = $posts["mediaPath"];
        $postID = $posts["id"];
        
        echo " <img src=\"$path\" onclick=\"openPost(".$postID.")\" alt=\"Image\" style=\"width:24%; aspect-ratio: 1 / 1; border-radius:0.5%; margin-left: auto; margin-right: auto; display:inline-block; position: relative;\">";     
    }

    
    echo "
    </div>
    </div>
    ";

    echo "</body>";
    echo "</html>";
    echo"
<script>
    var visible = false;

    
    

 function openPost(postID) {
    var element = document.getElementById(\"postcontainer\");
    element.style.visibility = \"visible\";
    console.log(\"visible\");
    visible = true;
    var postID = postID;  
    var id = ".$_SESSION['id'].";
    $.ajax({    
        type: \"POST\",
        url: \"displayposts.php\",       
        data: { postID: postID, id: id},      
        dataType: \"html\",   //expect html to be returned                
        success: function(response){                    
            $(\"#postcontainer\").html(response); 
            //alert(response);
        }

    });

    


  };

</script>
";

}else{

    header("Location: index.php");

    exit();

}

 ?>