<?php
    $greeting = "Change my Password";
    include 'inc/header2.php';
    include 'inc/connect.php';
?>

<html>
    <body>
        <form method="post" action="resetPassword.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Password:</label><br><input type="password" name="password">
            <br><label>Confirm Password:</label><br><input type="password" name="confirm">
            <br><input type="submit" value="Change my Password">
        </form>
    </body>
</html>

<?php

    function resetPassword() {

        global $conn;
        include 'inc/filter.php';
        $errors = [];

        if ((empty(filter($_POST['password']))) || empty(filter($_POST['confirm']))) {
            $errors[] = "Please type a password!";
        }

        if (filter($_POST['password']) != filter($_POST['confirm'])) {
            $errors[] = "Your passwords must match!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $hash = password_hash(filter($_POST['password']), PASSWORD_BCRYPT);
            $conn->query("UPDATE logIn SET password='".$hash."' WHERE email='".$_SESSION["email"]."'");
            header("location: login.php");
        }
    }

    if (isset($_POST['submitted'])) {
        resetPassword();
    }
?>