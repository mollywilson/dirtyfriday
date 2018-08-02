<?php

$sql4 = "SELECT * FROM logIn WHERE name='".$username."'";
$result = mysqli_query($conn, $sql4);

if (mysqli_num_rows($result) < 0) { //if username not exist

}//end of username does not exist yet
 else {
    echo "Sorry, this username is taken!";
 }

?>