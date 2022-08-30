<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    require('connection.php');

    require('topNav.php');

    require('chatIcon.php');

    $id = $_SESSION['id'];
    $sql = "SELECT id, mediaPath FROM posts WHERE userID = $id ORDER BY timePosted DESC";
    $selectresult = $con->query($sql);


    echo "<!DOCTYPE html>
        <html>
        <head>
        <title>HOME</title>
        <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script>
        </head>
        <body>
    ";

    $id = $_SESSION['id'];
    
    echo "<div id=\"postcontainer\"></div><div style=\" z-index: 1; margin-top: 5%; width: 80%; margin-left: auto; margin-right: auto;\">
    <img src=\"users/$id/profile\" alt=\"Profile image\" style=\"width:15%; aspect-ratio: 1 / 1; border-radius:50%; margin-left: auto; margin-right: auto; display:block;\">";

    echo "<p style=\"text-align: center; font-weight: bold;\">".$_SESSION['username']."</p>";

    
    echo "
    <div style=\"text-align: center\">
     <a href=\"followers.php\">Followers</a>

     <a href=\"following.php\">Following</a>
     <br>
     <a href=\"settings.php\">Settings</a>

    </div>";

    echo "
    <form action=\"upload.php\" method=\"post\" enctype=\"multipart/form-data\">
    Select image to upload:
    <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
    <input type=\"submit\" value=\"Upload Image\" name=\"submit\">
    </form>
    <div style=\display: flex;
    flex-wrap: wrap;\">";

    while($posts = mysqli_fetch_assoc($selectresult)){
        $path = $posts["mediaPath"];
        $postID = $posts["id"];
        echo " <img src=\"$path\" onclick=\"openPost(".$postID.")\" alt=\"Profile image\" style=\"width:24%; aspect-ratio: 1 / 1; border-radius:0.5%; margin-left: auto; margin-right: auto; display:inline-block; position: relative;\">"; 
        
    
    }

    
    echo "
    </div>
    </div>
    

    </body>

</html>";
echo"
<script>
    var visible = false;

    
    

 function openPost(postID) {
    var element = document.getElementById(\"postcontainer\");
    element.style.visibility = \"visible\";
    console.log(\"visible\");
    visible = true;
    var postID = postID;  
    var id = $id;
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