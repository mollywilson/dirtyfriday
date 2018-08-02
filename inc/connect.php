<?php

$servername = "localhost";
$user_name = "root";
$password = "";
$dbname = "dirty_fridays";

//create connection
$conn = mysqli_connect($servername, $user_name, $password, $dbname);
mysqli_select_db($conn,'dirty_fridays');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

?>