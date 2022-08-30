<?php
    include('connection.php');
    $id = $_POST['id'];
    $sql = "SELECT private FROM accounts WHERE id = $id";
    $selectresult = $con->query($sql);
    $private;
    while($result = mysqli_fetch_assoc($selectresult)){
        $private = $result["private"];
    }
    if($private == 0){
        $sql = "UPDATE accounts SET private = 1 WHERE id = $id";
        mysqli_query($con, $sql);
    } else if($private == 1) {
        $sql = "UPDATE accounts SET private = 0 WHERE id = $id";
        mysqli_query($con, $sql);

    }
?>