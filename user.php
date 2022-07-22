<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    require('connection.php');

    require('topNav.php');



    $id = $_GET['id'];

    if(intval($id) === intval($_SESSION['id'])){
        header("Location: profile.php");
    }


    $sql = "SELECT id, mediaPath FROM posts WHERE userID = $id ORDER BY timePosted DESC";
    $selectresult = $con->query($sql);
    $username = "";

    $sql1 = "SELECT username FROM accounts WHERE id = $id";
    $selectresult1 = $con->query($sql1);
    while($results = mysqli_fetch_assoc($selectresult1)){
        $username = $results["username"];
    }

    echo "<!DOCTYPE html>
        <html>
        <head>
        <title>HOME</title>
        <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script>
        </head>
        <body>
    ";

    
    echo "<div id=\"postcontainer\"></div><div style=\" z-index: 1; margin-top: 5%; width: 80%; margin-left: auto; margin-right: auto;\">
    <img src=\"users/$id/profile\" alt=\"Profile image\" style=\"width:15%; aspect-ratio: 1 / 1; border-radius:50%; margin-left: auto; margin-right: auto; display:block;\">";

    echo "<p style=\"text-align: center; font-weight: bold;\">".$username."</p>";

    
    echo "
    <div style=\"text-align: center\">
     <a href=\"userfollowers.php?id=$id\">Followers</a>

     <a href=\"userfollowing.php?id=$id\">Following</a>
     </div>";

    echo "
    <div style=\"display: flex;
    justify-content:space-between;\">";

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