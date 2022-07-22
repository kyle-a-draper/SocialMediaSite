<?php
include('connection.php');


    $postID = $_POST['postID'];

    $result = mysqli_query($con,"SELECT mediaPath, postText, timePosted, userID FROM posts WHERE id = $postID");
    echo "<div id=\"#postDisplay\">";
while($row = mysqli_fetch_assoc($result))
{   
    $path = $row['mediaPath'];
    $text = $row['postText'];
    $userID = $row['userID'];
    $id = $_POST['id'];
    $postID = $_POST['postID'];
    $username = "";

    $result1 = mysqli_query($con,"SELECT username FROM accounts WHERE id = $userID");
    while($row1 = mysqli_fetch_assoc($result1)){
        $username = $row1['username'];
    }

    echo"<img src=\"$path\"  style=\"  width:80%; 
    margin-left: auto; 
    margin-right: auto; 
    margin-top: 2%;
    display: block;\">
    <div style=\"width: 80%; display: inline-block;\">
        <p class=\"postsUsernameDisplay\">".$username."</p>
        <p class=\"postsTextDisplay\">".$text."</p>
    </div>
    <input type=\"image\" style=\" float: right; width:30px;height:30px\" onclick=\"likePost($postID,$id)\" src=\"heart.png\" />
    ";
    
}
    echo "</div>";
    echo "<script>
    document.addEventListener('click', function handleClickOutsideBox(event) {
        var target = this;
        box = document.getElementById('postcontainer');
      
        if (!box.contains(event.target)) {
          box.style.visibility = 'hidden';
          this.removeEventListener('click', handleClickOutsideBox);

          console.log(\"here\");
        }
      });
    </script>";
    echo"
    <script>
    function likePost(postID, likerID) {
        console.log(postID + \" \" + likerID);
        var postID = postID;
        var likerID = likerID;
        $.ajax({
            type: \"POST\",
            url: \"likePost.php\",
            data: { postID: postID, likerID: likerID},            
            dataType: \"string\",
          });
    }
</script>";


 ?>