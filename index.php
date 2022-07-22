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
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $sql = "SELECT id, password FROM accounts WHERE username = '$username'";
        $result = $con->query($sql);
        $accounts = $result->fetch_assoc();

        if (mysqli_num_rows($result) > 0){
            $id = $accounts["id"];
            $accountpassword = $accounts["password"];
            if (password_verify($_POST['password'], $accountpassword))
            {
                session_start();
                echo "<h3>You are logged in successfully.</h3><br/>";
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $id;
                header("Location: home.php");

            } 
            else {
                echo "<div class='form'>
                    <h3>Required fields are missing.</h3><br/>
                    <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                    </div>";
            }
    }
    } else {
?>
        <div class="login">
        <form action="" method="post">

            <label for="username">Username</label>
            <input class="loginInput" type="text" id="username" name="username" placeholder="Username">

            <label for="password">Password</label>
            <input class="loginInput" type="password" id="password" name="password" placeholder="Password">

            <input class="loginButton" type="submit" value="Submit">

            <a href="createAccount.html">Create an account</a>
            <a href="forgotPassword.html">Forgot Password</a>
        </form>
        </div>
        <?php
    }
?>


    </body>
</html>