<?php
    if(isset($_SESSION)) {
        session_destroy();
    }

    if(!isset($_SESSION)) {
        session_start();
    }

    include 'inc/connect.php';
    $greeting = "Log In!";

    //function filter($string) {
    //    $string = strip_tags($string);
    //    $string = mysqli_real_escape_string($conn, $string);

    //    return $string;
    //}

    include 'inc/header2.php';
?>

<html>
    <head>
        <link rel="stylesheet" href="css/dirtyFriday.css">
        <title>Dirty Friday</title>
    </head>
    <body>

        <div class="form">
            <form method="post" action="login.php">
                <input type="hidden" name="submitted" value="true" />
                <br><label>Username:</label><br> <input type="text" name="username">
                <br><label>Password:</label><br> <input type="password" name="password">
                <br><input type="submit" value="Log Me In!">
            </form>
        </div>

    </body>
</html>

<?php

    if (isset($_POST['submitted'])) { //if form is submitted

        $username = $_POST['username'];
        $password = $_POST['password'];

        $dbpassword = "SELECT password FROM logIn WHERE name='".$username."'"; //if username exists
        $result = mysqli_query($conn, $dbpassword);

        if ((!empty($username)) && (!empty($password))) { //if form not empty

            if (mysqli_num_rows($result) > 0) { //if username exists
                $row = $result->fetch_array();
                    if (password_verify($password, $row['password'])) {
                        //echo "SUCCESS";
                        $_SESSION["username"] = $username;
                        header("Location: index.php");
                    }// end of password verify
            else {
                echo "Your username or password is incorrect";
            } // end of password verify else
        }// end of if username exists
            else {
                echo "Your username or password is incorrect";
            } //end of username exists else
        }//end of if not empty
        else {
            echo "Please fill in your details";
        }// end of if not empty else
    }// end of isset
?>