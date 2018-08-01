<?php
$greeting = "Sign Up";
include 'inc/connect.php';
include 'inc/header.php';
?>
<html>
<head>
    <link rel="stylesheet" href="css/dirtyFriday.css">
    <title>Dirty Friday</title>
</head>
<body>

<form method="post" action="signup.php">
    <input type="hidden" name="submitted" value="true" />
    <br>Name: <input type="text" name="signup_name">
    <br>Email: <input type="text" name="signup_email">
    <br>Password: <input type="password" name="password">
    <br> <input type="submit" value="Sign Me Up!">
</form>
</body>
</html>

<?php
    if (isset($_POST['submitted'])) {

    $signup_name = mysqli_real_escape_string($conn, $_POST['signup_name']);
    $signup_name = strip_tags($signup_name);
    $signup_email = mysqli_real_escape_string($conn, $_POST['signup_email']);
    $signup_email = strip_tags($signup_email);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = strip_tags($password);

    if ((!empty($signup_name)) && (!empty($signup_email)) && (!empty($password))) {

    include 'connect.php';

    $sql = "INSERT INTO logIn (name, email, password) VALUES
            ('$signup_name', '$signup_email', '$password')";

    if (!mysqli_query($conn, $sql)) {
        die('Your user has NOT been created');
    } //end of nested if statement
    else {
        header("location: index.php");
        }
    } else {
    echo "Please fill in your details!";
        }
    } // end of if isset
?>