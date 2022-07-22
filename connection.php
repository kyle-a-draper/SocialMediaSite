<?php
$servername = "localhost";
$database = "mydb";
$username = "root";
$password = "password";

$con = mysqli_connect($servername, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>