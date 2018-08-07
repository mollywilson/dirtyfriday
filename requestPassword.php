<?php
    $greeting = "Change my Password!";
    include 'inc/header2.php';
    include 'inc/connect.php';


    $url = "http://molly.localhost/dirtyFriday/resetPassword.php";
    $admin_name = "Dirty Fridays";
    $admin_email = "molly@Mollys-MBP.magmadigital.co.uk";

?>

<html>
    <form method="post" action="requestPassword.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Name:</label> <input type="text" name="username">
        <br><label>Email:</label> <input type="text" name="email">
        <br><input type="submit" value="Send me an Email!">
    </form>
</html>

<?php

function requestPassword() {

    global $conn;
    include 'inc/filter.php';
    $errors = [];
    $email = filter($_POST['email']);
    $result = mysqli_query($conn, "SELECT * FROM logIn WHERE name='".filter($_POST['username'])."' AND email='".filter($_POST['email'])."'");
    $email_hash = password_hash(filter($_POST['email']), PASSWORD_BCRYPT);
    $link = "http://molly.localhost/dirtyFriday/resetPassword.php?key=".$email_hash."";
    $_SESSION["email"] = filter($_POST['email']);

    if ((empty(filter($_POST['username']))) || (empty(filter($_POST['email'])))) {
        $errors[] = "Please enter your username and email address";
    }

    if (mysqli_num_rows($result) == 0) {
        $errors[] = "Your username or password is incorrect";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        mail("$email", 'Dirty Fridays: Forgot my Password', "Please click the link to change your password!" . "$link");
        echo "Your email has been sent!";
    }
}

if (isset($_POST['submitted'])) {
    requestPassword();
}