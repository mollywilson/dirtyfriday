

<?php
    include 'inc/connect.php';
    $greeting = "Log In!";
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

    if (isset($_POST['submitted'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $username = strip_tags($username);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = strip_tags($password);

        $sql = "SELECT * FROM logIn WHERE name='".$username."' AND password='".$password."'"; //sql command to test user password
        $result = mysqli_query($conn, $sql); //user exists

        if ((!empty($username)) && (!empty($password))) {

            if (mysqli_num_rows($result) > 0) {
                $_SESSION["username"] = $username;
                header("Location: index.php");
            }// end of user check
            else {
                echo "Your username or password is incorrect";
            } // end of user else
        }// end of if empty
        else {
            echo "Please fill in your details";
        }// end of if empty else
    }// end of isset
?>