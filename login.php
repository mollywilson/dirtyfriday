<?php
    if(isset($_SESSION)) {
        session_destroy();
    }

    if(!isset($_SESSION)) {
        session_start();
    }

    $image = "pics/kfc_banner.jpg";
    $greeting = "Log In!";

?>
    <body>
        <div class="container fill col-lg-12 bg-light text-center">
            <?php include 'inc/header2.php'; ?>
            <div class="row">
                <form class="col-lg-12" method="post" action="login.php">
                    <input type="hidden" name="submitted" value="true" />
                    <br><label>Username:</label><br><input class="col-3" type="text" autocomplete="new-password" name="username">
                    <br><label>Password:</label><br><input class="col-3" type="password" autocomplete="new-password" name="password">
                    <br><input type="submit" class="btn btn-outline-dark" value="Log Me In!">
                </form>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center text-danger">
                    <?php
                    if (isset($_POST['submitted'])) {
                        login();
                    }
                    ?>
                </div>
            </div>
            <!-- sign in form -->
            <?php include 'inc/footer.php' ?>
        </div>



<?php
function login() {
    include 'inc/filter.php';
    global $conn;
    $errors = [];
    $result = $conn->query(sprintf("SELECT password FROM users WHERE name = '%s'", filter($_POST['username'])));
    $row = $result->fetch_array();

    if ((empty(filter($_POST['username']))) || (empty(filter($_POST['password'])))) {
        $errors[] = "You must enter your username and password!";
    }

    if (mysqli_num_rows($result) == 0) {
        $errors[] = "Your username or password is incorrect!";
    }

    if (!password_verify(filter($_POST['password']), $row['password'])) {
        $errors[] = "Your username or password is incorrect!";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        $user_id = ($conn->query(sprintf("SELECT id FROM users WHERE name = '%s'", filter($_POST['username']))))->fetch_assoc();
        $_SESSION['user_id'] = $user_id["id"];
        header("location: index.php");
    }
}
?>
    </body>
</html>