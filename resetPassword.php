<?php
    $greeting = "Change my Password";
    include 'inc/header2.php';
    include 'inc/connect.php';

    $selector = filter_input(INPUT_GET, 'selector');
    $validator = filter_input(INPUT_GET, 'validator');
?>

<html>
    <body>
        <form method="post">
            <input type="hidden" name="submitted" value="true" />
            <input type="hidden" name="selector" value="<?php echo $selector; ?>">
            <input type="hidden" name="validator" value="<?php echo $validator; ?>">
            <br><label>Password:</label><br><input type="password" name="password">
            <br><label>Confirm Password:</label><br><input type="password" name="confirm">
            <br><input type="submit" value="Change my Password">
        </form>
    </body>
</html>

<?php

    function resetPassword() {

        global $conn, $selector, $validator;
        include 'inc/filter.php';
        $errors = [];

        if (true !== ctype_xdigit($selector) || true !== ctype_xdigit($validator)) {
            $errors[] = "Unfortunately, the request cannot be processed";
        }

        $results = $conn->query(sprintf("SELECT * FROM reset WHERE selector = '%s'", $selector));
        $record = $results->fetch_assoc();

        if ((mysqli_num_rows($results)) == 0) {
            $errors[] = "Unfortunately, the request cannot be processed";
        }

        if ((empty(filter($_POST['password']))) && empty(filter($_POST['confirm']))) {
            $errors[] = "Please type a password!";
        }

        if (filter($_POST['password']) != filter($_POST['confirm'])) {
            $errors[] = "Your passwords must match!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $hash = password_hash(filter($_POST['password']), PASSWORD_BCRYPT);
            $conn->query(sprintf("UPDATE logIn SET password = '%s' WHERE logIn.email = '%s'", $hash, $record['email']));
            $conn->query(sprintf("DELETE FROM reset WHERE selector = '%s'", $selector));
            header("location: login.php");
        }
    }

if (isset($_POST['submitted'])) {
        resetPassword();
    }
?>