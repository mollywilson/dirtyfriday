<?php
    $greeting = "Change my Password!";
    include 'inc/header2.php';
    include 'inc/connect.php';

?>

<html>
    <form method="post" action="requestPassword.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Email:</label><input type="text" name="email">
        <br><input type="submit" value="Send me an Email!">
    </form>
</html>

<?php

function requestPassword() {

    global $conn;
    include 'inc/filter.php';
    $errors = [];
    $email = filter($_POST['email']);
    $result = $conn->query("SELECT * FROM logIn WHERE email='".filter($_POST['email'])."'");
    $_SESSION["email"] = filter($_POST['email']);

    if (empty(filter($_POST['email']))) {
        $errors[] = "Please enter your email address";
    }

    if (mysqli_num_rows($result) == 0) {
        $errors[] = "Sorry, this email address is not linked to an account!";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        $resetTokens = array(
            'selector' => $selector,
            'validator' => bin2hex($token)
        );

        $url = "http://molly.localhost/dirtyFriday/resetPassword.php?" . http_build_query($resetTokens);

        $expires = new DateTime('NOW');
        $expires->add(new DateInterval('PT01H'));

        $conn->query("DELETE FROM reset WHERE email='".filter($_POST['email'])."'");

        $conn->query("INSERT INTO reset (email, token, expires, selector) VALUES 
                    ('".filter($_POST['email'])."', '".hash('sha256', $token)."', '".$expires->format('U')."', '".$selector."')");

        $sent = mail("$email", 'Dirty Fridays: Forgot my Password', "Please click the link below to change your password! If you did not make this request, you can ignore this email." . "\n" . "$url");

        if (false !== $sent) {
            echo "Your email has been sent!";
            session_destroy();
        }
    }
}

if (isset($_POST['submitted'])) {
    requestPassword();
}