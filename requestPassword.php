<?php
    $greeting = "Change my Password!";
    include 'inc/header2.php';
    include 'inc/connect.php';

?>

<html>
<body>
    <div class="form-group text-center">
    <form method="post" action="requestPassword.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Email:</label>
        <br><input class="col-3" type="text" name="email">
        <br><input type="submit" class="btn btn-outline-dark" value="Send me an Email!">
    </form>
    </div>

<?php

function requestPassword()
{

    global $conn;
    include 'inc/filter.php';
    $errors = [];
    $email = filter($_POST['email']);
    $result = $conn->query(sprintf("SELECT * FROM users WHERE email = '%s'", filter($_POST['email'])));
    $row = $result->fetch_assoc();
    $id_user = $row["id"];

    if (empty(filter($_POST['email']))) {
        $errors[] = "Please enter your email address!";
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

        $conn->query(sprintf("DELETE FROM reset WHERE user_id = '%s'", $id_user));

        $conn->query(sprintf("INSERT INTO reset (user_id, token, expires, selector) VALUES ('%s', '%s', '%s', '%s')",
            "$id_user", hash('sha256', $token), $expires->format('U'), $selector));

        $sent = mail("$email", 'Dirty Fridays: Forgot my Password',
            "Please click the link below to change your password! If you did not make this request, you can ignore this email." . "\n" . "$url");

?>
    <div class="container text-center text-success">
        <?php
        if (false !== $sent) {
            echo "Your email has been sent!";
            session_destroy();
        }   }   } ?> </div>
    <div class="container text-center text-danger">
        <?php
        if (isset($_POST['submitted'])) {
            requestPassword();
        }
        ?>
    </div>
        </body>
</html>
