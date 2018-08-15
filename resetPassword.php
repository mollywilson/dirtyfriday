<?php
    $image = "pics/stirfry_banner.jpg";
    include 'inc/header.php';

    $selector = filter_input(INPUT_GET, 'selector');
    $validator = filter_input(INPUT_GET, 'validator');
?>

<html>
    <body>
    <div class="container fill col-lg-12 bg-light">
        <?php include 'inc/header2.php'; ?>
        <div class="row">
            <div class="text-center col-lg-12">
                <form method="post">
                    <input type="hidden" name="submitted" value="true" />
                    <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                    <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                    <br><label>Password:</label><br><input class="col-3" type="password" name="password">
                    <br><label>Confirm Password:</label><br><input class="col-3" type="password" name="confirm">
                    <br><input class="btn btn-outline-dark" type="submit" value="Change my Password">
                </form>
            </div>
        </div> <!-- password form -->
        <div class="row">
            <div class="col-lg-12 text-center text-danger">
                <?php
                if (isset($_POST['submitted'])) {
                resetPassword();
                } ?>
            </div>
        </div> <!-- errors -->
        <?php include 'inc/footer.php'; ?>
    </div>
    </body>
</html>

<?php

    function resetPassword() {

        global $conn, $selector, $validator;
        include 'inc/filter.php';
        $errors = [];

        if (true !== ctype_xdigit($selector) || true !== ctype_xdigit($validator)) {
            $errors[] = "Unfortunately, the request cannot be processed.";
        }

        $results = $conn->query(sprintf("SELECT * FROM reset WHERE selector = '%s'", $selector));
        $row = $results->fetch_assoc();

        if ((mysqli_num_rows($results)) == 0) {
            $errors[] = "Unfortunately, the request cannot be processed.";
        }

        if ((empty(filter($_POST['password']))) && empty(filter($_POST['confirm']))) {
            $errors[] = "Please type a password!";
        }

        if (strlen(filter($_POST['password'])) < 6) {
            $errors[] = "Your password must be 6 or more characters.";
        }

        if (filter($_POST['password']) != filter($_POST['confirm'])) {
            $errors[] = "Your passwords must match!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $id_user = $row['user_id'];
            $hash = password_hash(filter($_POST['password']), PASSWORD_BCRYPT);
            //something wrong with this command
            $conn->query(sprintf("UPDATE users SET password = '%s' WHERE id = '%s'", $hash, $id_user));
            $conn->query(sprintf("DELETE FROM reset WHERE selector = '%s'", $selector));
            header("location: login.php");
        }
    }