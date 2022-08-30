<?php 
require('connection.php');

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    echo "<!DOCTYPE html>
          <html>";
    echo "<head>        <link rel=\"stylesheet\" href=\"styles.css\"><script src=\"jquery.js\"></script></head>";
    echo "<body>";
    require('topNav.php');
    $id = $_SESSION['id'];

    $sql = "SELECT private FROM accounts WHERE id = $id";
    $selectresult = $con->query($sql);
    $private;
    while($result = mysqli_fetch_assoc($selectresult)){
        $private = $result["private"];
    }
    
    echo((int) $private);

    echo"
    <div style=\"margin-left: auto; margin-right: auto; margin-top: 5%; width: 40%; height: 5%;\">

    <label for=\"privateSwitch\" style=\"font-size: 200%; font-weight: bold; font-family: Arial;\">Private Account        </label>

    <label class=\"switch\">";
    if($private == 0){
        echo"<input id=\"privateSwitch\" onclick=\"togglePrivate()\" type=\"checkbox\">";
    } else if($private == 1) {
        echo"<input id=\"privateSwitch\" onclick=\"togglePrivate()\" type=\"checkbox\" checked=\"true\">";
    }
    echo"
    <span class=\"slider round\"></span>
    </label>
    </div>";

    


    echo "</body>";
    echo "</html>";

    echo"
<script>
 function togglePrivate() {
    var id = $id;
    $.ajax({    
        type: \"POST\",
        url: \"togglePrivate.php\",       
        data: {id: id},      
        success: function(response){                    
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