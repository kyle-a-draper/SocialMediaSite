<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>

        <?php
    require('connection.php');
    if (isset($_REQUEST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $hashedpword = password_hash($password, PASSWORD_DEFAULT);
        $create_datetime = date("Y-m-d H:i:s");
        $query    = "INSERT into `accounts` (username, password, email, create_datetime)
                     VALUES ('$username', '$hashedpword', '$email', '$create_datetime')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            $sql = "SELECT id FROM accounts WHERE username = '$username'";
            $selectresult = $con->query($sql);
            $accounts = $selectresult->fetch_assoc();
            if (mysqli_num_rows($selectresult) > 0){
                $id = $accounts["id"];
                mkdir("users/".$id);
                $followersfile = fopen("users/".$id."/followers.txt", "w");
                $followingfile = fopen("users/".$id."/following.txt", "w");
                fclose($followersfile);
                fclose($followingfile);
                echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='index.php'>Login</a></p>
                  </div>";
            }
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } else {
?>

        <div class="login">
        <form action="" method="post">

            <label for="email">Email</label>
            <input class="loginInput" type="text" id="email" name="email" placeholder="Email">

            <label for="username">Username</label>
            <input class="loginInput" type="text" id="username" name="username" placeholder="Username">

            <label for="password">Password</label>
            <input class="loginInput" type="password" id="password" name="password" placeholder="Password">



            <input class="loginButton" type="submit" value="Submit">

            <a href="index.html">Login</a>
        </form>
        </div>
<?php
    }
?>


    </body>
</html>