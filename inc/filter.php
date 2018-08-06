<?php

    function filter($string) {

    include 'connect.php';

    $string = mysqli_real_escape_string($conn, $string);
    $string = strip_tags($string);

    return $string;
    }

?>