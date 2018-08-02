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
    if (isset($_POST['submitted'])) { //IF ISSET

    $signup_name = mysqli_real_escape_string($conn, $_POST['signup_name']);
    $signup_name = strip_tags($signup_name);
    $signup_email = mysqli_real_escape_string($conn, $_POST['signup_email']);
    $signup_email = strip_tags($signup_email);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    //$password = strip_tags($password);

    if ((!empty($signup_name)) && (!empty($signup_email)) && (!empty($password))) { //IF NOT EMPTY

    include 'connect.php';

        $hash = password_hash($password, PASSWORD_BCRYPT); //TO HASH THE PASSWORD

        $sql = "INSERT INTO logIn (name, email, password) VALUES 
            ('$signup_name', '$signup_email', '$hash')"; //MYSQL COMMAND TO STORE DETAILS TO DATABASE

    if (!mysqli_query($conn, $sql)) { //IF DETAILS CANNOT BE STORED
        die('Your user has NOT been created');
    } //end of IF CANNOT BE STORED
    else {
        $_SESSION["username"] = $signup_name;
        header("location: index.php");
        } //END OF CANNOT BE STORED ELSE
    } //END OF IF NOT EMPTY
    else {
    echo "Please fill in your details!";
        } //END OF IF NOT EMPTY ELSE
    } // end of if isset
?>