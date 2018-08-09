<?php
$greeting = "Sign Up";
include 'inc/connect.php';
include 'inc/header2.php';
?>
    <body>
    <div class="form">
    <form method="post" action="signup.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Username:</label>
        <br><input type="text" name="username">
        <br><label>Email:</label>
        <br><input type="text" name="email">
        <br><label>Password:</label>
        <br><input type="password" name="password">
        <br><label>Confirm Password:</label>
        <br><input type="password" name="cpassword">
        <br> <input type="submit" value="Sign Me Up!">
    </form>
    </div>
    </body>
    </html>

<?php

function signup() {

    global $conn;
    include 'inc/filter.php';
    $errors = [];
    $result = $conn->query(sprintf("SELECT * FROM logIn WHERE name = '%s' ", filter($_POST['username'])));
    $result1 = $conn->query(sprintf("SELECT * FROM logIn WHERE email = '%s' ", filter($_POST['email'])));
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

    if (strlen(filter($_POST['password'])) < 8) {
        $errors[] = "Your password must be 8 or more characters";
    }

    if (filter($_POST['password']) != filter($_POST['cpassword'])) {
        $errors[] = "Your passwords do not match";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        $conn->query(sprintf("INSERT INTO logIn (name, email, password) VALUES ('%s', '%s', '%s')", filter($_POST['username']), filter($_POST['email']), $hash));
        $_SESSION["username"] = filter($_POST['username']);
        header("location: login.php");
    }
}

if (isset($_POST['submitted'])) {
    signup();
}