<?php
    if(isset($_SESSION)) {
        session_destroy();
    }

    if(!isset($_SESSION)) {
        session_start();
    }

    include 'inc/connect.php';
    $greeting = "Log In!";

    include 'inc/header2.php';

?>
    <body>
        <div class="form">
            <form method="post" action="login.php">
                <input type="hidden" name="submitted" value="true" />
                <br><label>Username:</label><br><input type="text" name="username">
                <br><label>Password:</label><br><input type="password" name="password">
                <br><input type="submit" value="Log Me In!">
            </form>
        </div>

    </body>
</html>

<?php
function login() {

    include 'inc/filter.php';
    global $conn;
    $errors = [];
    $result = $conn->query(sprintf("SELECT password FROM users WHERE name = '%s'", filter($_POST['username'])));
    $row = $result->fetch_array();

    if ((empty(filter($_POST['username']))) || (empty(filter($_POST['password'])))) {
        $errors[] = "You must enter your username and password";
    }

    if (mysqli_num_rows($result) == 0) {
        $errors[] = "Your username or password is incorrect";
    }

    if (!password_verify(filter($_POST['password']), $row['password'])) {
        $errors[] = "Your username or password is incorrect";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        $user_id = ($conn->query(sprintf("SELECT id FROM users WHERE name = '%s'", filter($_POST['username']))))->fetch_assoc();
        $_SESSION['user_id'] = $user_id["id"];
        header("location: index.php");
    }
}

if (isset($_POST['submitted'])) {
    login();
}
?>