<?php

$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbNmae = "loginuser";
$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbNmae);

if(!$conn){
    die("Something went wrong");
}

?>