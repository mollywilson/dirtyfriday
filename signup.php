<?php
$greeting = "Sign Up";
include 'inc/connect.php';
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


        <form method="post" action="signup.php">
            <input type="hidden" name="submitted" value="true" />
            <br>Username: <input type="text" name="signup_name">
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
    $password = password_hash($password, PASSWORD_BCRYPT);

    if ((!empty($signup_name)) && (!empty($signup_email)) && (!empty($password))) {

    include 'connect.php';

    $sql = "INSERT INTO logIn (name, email, password) VALUES
            ('$signup_name', '$signup_email', '$password')";

    if (!mysqli_query($conn, $sql)) {
        die('Your user has NOT been created');
    } //end of nested if statement
    else {
        $_SESSION["username"] = $signup_name;
        header("location: index.php");
        }
    } else {
    echo "Please fill in your details!";
        }
    } // end of if isset
?>