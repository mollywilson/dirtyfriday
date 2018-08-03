<?php
    $greeting = "Change my Password!";
    include 'inc/header.php';
    include 'inc/connect.php';


    $url = "http://molly.localhost/dirtyFriday/change.php";
    $admin_name = "Molly Wilson";
    $admin_email = "molly@Mollys-MBP.magmadigital.co.uk";
    $message = "Please click the link to change your password!" . "<br />\n"
                . "molly.localhost/dirtyFriday/change.php";
?>

<html>
    <form method="post" action="password.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Name:</label> <input type="text" name="username">
        <br><label>Email:</label> <input type="text" name="email">
        <br><input type="submit" value="Send me an Email!">
    </form>
</html>


<?php

    if (isset($_POST['submitted'])) { //if form submitted

        $name = filter($_POST['username']);
        $email = filter($_POST['email']);

        $sql = "SELECT * FROM logIn WHERE name='".$name."' AND email='".$email."'";
        $result = mysqli_query($conn, $sql);

        if ((!empty($name)) && (!empty($email))) { //if not empty

            if (mysqli_num_rows($result) > 0) { //if name and email match

                mail("$email", "Dirty Fridays: Forgot my Password", "$message");
                echo "Your email has been sent!";
            }//end of if name and email match
            else {
                echo "Your name or email address is incorrect!";
            }//end of name and email address else
        } //end of if not empty
        else {
            echo "Please fill in your details";
        }//end of if not empty else
    }//end of form submitted