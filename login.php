<?php
    include 'inc/connect.php';
    $greeting = "Log In!";

    //function filter($string) {
    //    $string = strip_tags($string);
    //    $string = mysqli_real_escape_string($conn, $string);

    //    return $string;
    //}
?>

<html>
    <head>
        <link rel="stylesheet" href="css/dirtyFriday.css">
        <title>Dirty Friday</title>
    </head>
    <body>

        <div id="header">
        <a href="signup.php">Sign Up</a>
        <a href="login.php">Log In</a>
        <a href="" id="title">Dirty Fridays: <i><?php echo $greeting; ?></i></a>
        </div>

        <form method="post" action="login.php">
            <input type="hidden" name="submitted" value="true" />
            <br>Username: <input type="text" name="username">
            <br>Password: <input type="password" name="password">
            <br> <input type="submit" value="Log Me In!">
        </form>
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