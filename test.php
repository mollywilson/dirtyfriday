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

            $link = "http://molly.localhost/dirtyFriday/resetPassword.php?key=".$email_hash."";

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

?>

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
            mail("$email", 'Dirty Fridays: Forgot my Password', "$message" . "$link");
            echo "Your email has been sent!";
        }
    }

    if (isset($_POST['submitted'])) {
        requestPassword();
    }
