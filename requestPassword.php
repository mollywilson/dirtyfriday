<?php
    $image = "pics/spring_roll_banner.jpg";
    include 'inc/header.php'; ?>

            <div class="container fill text-center col-lg-12 bg-light">
        <div class="row">
        <form class="col-lg-12" method="post" action="requestPassword.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Email:</label>
            <br><input class="col-3" type="text" name="email">
            <br><input type="submit" class="btn btn-outline-dark" value="Send me an Email!">
        </form>

<?php
function requestPassword() {

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
    if (!filter_var(filter($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
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

        $url = "dirty_friday.test/resetPassword.php?" . http_build_query($resetTokens);

        $expires = new DateTime('NOW');
        $expires->add(new DateInterval('PT01H'));

        $conn->query(sprintf("DELETE FROM reset WHERE user_id = '%s'", $id_user));

        $conn->query(sprintf("INSERT INTO reset (user_id, token, expires, selector) VALUES ('%s', '%s', '%s', '%s')",
            "$id_user", hash('sha256', $token), $expires->format('U'), $selector));
        $message = "Please click the link below to change your password! If you did not make this request, you can ignore this email. If the link fails, please copy and paste it into the browser." . "\n" . "$url";
        //var_dump($message); die();
        $sent = mail("$email", 'Dirty Fridays: Forgot my Password',
            $message);

?>
        <div class="container text-center text-success">
        <?php
        if (true === $sent) {
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
    </div> <!-- email form -->
<?php include 'inc/footer.php'; ?>