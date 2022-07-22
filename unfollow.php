<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $unfollowid = $_POST['unfollow'];
    $id = $_SESSION['id'];
    $followersString = file_get_contents("users/".$id."/following.txt");

    $followersArr = explode(',', $followersString);
    $followersArr2 = [count($followersArr)-1];
    $i = 0;
    for($i;$i < count($followersArr);$i++){
        if(intval($followersArr[$i]) === intval($unfollowid)){
            $followersArr[$i] = 0;
            $followersArr[$i+1] = 0;
            break;
        }
    }
    for($i = 0;$i < count($followersArr);$i++){
        if(intval($followersArr[$i]) !== intval(0)){
            $followersArr2[$i] = $followersArr2[$i];
        }
    }
    $file = fopen("users/".$id."/following.txt", "w");
    fwrite( $file,  $followersArr2[0]);
    $file = fopen("users/".$id."/following.txt", "a");

    for($i = 1;$i < count($followersArr2);$i++){
        if($i < count($followersArr2)-1){
            fwrite( $file,  ",");
        }
        fwrite( $file,  $followersArr2[$i]);

    }
    header("Location: Home.php");
}else{

    header("Location: index.php");

    exit();

}
?>