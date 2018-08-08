<?php
$greeting = "Sign Up";
include 'inc/connect.php';
include 'inc/header2.php';
?>

    <html>
    <head>
        <link rel="stylesheet" href="css/dirtyFriday.css">
        <title>Dirty Friday</title>
    </head>
    <body>
    <form method="post" action="signup.php">
        <input type="hidden" name="submitted" value="true" />
        <br>Username: <input type="text" name="username">
        <br>Email: <input type="text" name="email">
        <br>Password: <input type="password" name="password">
        <br>Confirm Password: <input type="password" name="cpassword">
        <br> <input type="submit" value="Sign Me Up!">
    </form>
    </body>
    </html>

<?php

function signup() {

    global $conn;
    include 'inc/filter.php';
    $errors = [];
    $result = $conn->query("SELECT * FROM logIn WHERE name='" . filter($_POST['username']) . "'");
    $result1 = $conn->query("SELECT * FROM logIn WHERE email='".filter($_POST['username'])."'");
    $hash = password_hash(filter($_POST['password']), PASSWORD_BCRYPT);

    if ((empty(filter($_POST['username']))) || (empty(filter($_POST['email']))) || (empty(filter($_POST['password']))) || (empty(filter($_POST['cpassword'])))) {
        $errors[] = "Please fill in your details!";
    }

    if (($result->num_rows) == 1) {
        $errors[] = "This username is taken!";
    }

    if (($result1->num_rows == 1)) {
        $errors[] = "This email has already been used";
    }

    if (!filter_var(filter($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email";
    }

    if (filter($_POST['password']) == filter($_POST['cpassword'])) {
        $errors[] = "Your passwords do not match";
    }

    if (empty($errors)) {
        echo $errors[0];
    } else {
        $conn->query("INSERT INTO logIn (name, email, password) VALUES ('".filter($_POST['username'])."', '".filter($_POST['email'])."', '$hash')");
        $_SESSION["username"] = filter($_POST['username']);
        header("location: login.php");
    }
}

if (isset($_POST['submitted'])) {
    signup();
}