<?php

$servername = "localhost";
$userName = "root";
$password = "";
$dbname = "dirty_friday_fks";

//create connection
$conn = mysqli_connect($servername, $userName, $password, $dbname);
mysqli_select_db($conn,'dirty_fridays');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    if(!isset($_SESSION)) {
        session_start();
    }
?>