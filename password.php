<?php
    $greeting = "Change my Password!";
    include 'inc/header.php';
    include 'inc/connect.php';


    $url = "http://molly.localhost/dirtyFriday/change.php";
    $admin_name = "Dirty Fridays";
    $admin_email = "molly@Mollys-MBP.magmadigital.co.uk";
    $message = "Please click the link to change your password!" . "\n";

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

        include 'inc/filter.php';

        $name = filter($_POST['username']);
        $email = filter($_POST['email']);

        $sql = "SELECT * FROM logIn WHERE name='".$name."' AND email='".$email."'";
        $result = mysqli_query($conn, $sql);

        if ((!empty($name)) && (!empty($email))) { //if not empty

            if (mysqli_num_rows($result) == 1) { //if name and email match

                while ($row = mysqli_fetch_array($result)) {
                    $email_hash = password_hash($email, PASSWORD_BCRYPT);
                }

                $link = "http://molly.localhost/dirtyFriday/change.php?key=".$email_hash."";
                
                $_SESSION["email"] = $email;

                mail("$email", "Dirty Fridays: Forgot my Password", "$message" . "$link");
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