<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dirty_fridays";

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_select_db($conn,'dirty_fridays');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

?>