<?php
$image = "pics/chicken1_banner.jpg";
include 'inc/header.php';
?>
    <body>
    <div class="container fill text-center col-lg-12 bg-light">
        <?php include 'inc/header2.php'; ?>
        <div class="row">
            <div class="container col-lg-12">
                <form method="post" action="signup.php">
                    <input type="hidden" name="submitted" value="true" />
                    <br><label>Username:</label>
                    <br><input class="col-3" type="text" name="username">
                    <br><label>Email:</label>
                    <br><input class="col-3" type="text" name="email">
                    <br><label>Password:</label>
                    <br><input class="col-3" type="password" name="password">
                    <br><label>Confirm Password:</label>
                    <br><input class="col-3" type="password" name="cpassword">
                    <br><input type="submit" class="btn btn-outline-dark" value="Sign Me Up!">
                </form>
            </div>
        </div> <!--signup form start -->

<?php

function signup() {

    global $conn;
    include 'inc/filter.php';
    $errors = [];
    $result = $conn->query(sprintf("SELECT * FROM users WHERE name = '%s' ", filter($_POST['username'])));
    $result1 = $conn->query(sprintf("SELECT * FROM users WHERE email = '%s' ", filter($_POST['email'])));
    $hash = password_hash(filter($_POST['password']), PASSWORD_BCRYPT);

    if ((empty(filter($_POST['username']))) || (empty(filter($_POST['email']))) || (empty(filter($_POST['password']))) || (empty(filter($_POST['cpassword'])))) {
        $errors[] = "Please fill in your details!";
    }

    if (($result->num_rows) == 1) {
        $errors[] = "This username is taken!";
    }

    if (($result1->num_rows == 1)) {
        $errors[] = "This email has already been used";
    }

    if (!filter_var(filter($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email";
    }

    if (strlen(filter($_POST['password'])) < 6) {
        $errors[] = "Your password must be 6 or more characters";
    }

    if (filter($_POST['password']) != filter($_POST['cpassword'])) {
        $errors[] = "Your passwords do not match";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        $conn->query(sprintf("INSERT INTO users (name, email, password) VALUES ('%s', '%s', '%s')", filter($_POST['username']), filter($_POST['email']), $hash)); ?>
        <div class="row">
            <div class="container text-center text-success">
                <form class="form" action="login.php">
                    <br><label>Thank you for signing up</label>
                    <br><input type="submit" class="btn btn-outline-dark" name="login" value="Log In!">
                </form>
            </div>
        </div>

<?php
    }
}
?>
        <div class="row">
            <div class="container text-center text-danger">
                <?php
                if (isset($_POST['submitted'])) {
                signup();
                } ?>
            </div>
        </div> <!-- signup form -->
        <?php include 'inc/footer.php'; ?></div>
    </body>
</html>