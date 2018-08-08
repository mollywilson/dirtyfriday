<?php
$greeting = "Change my Username";
include 'inc/header.php';
include 'inc/connect.php';
?>

<hmtl>
    <div class="form">
        <form method="post">
            <input type="hidden" name="submitted" value="true" />
            <br><label>New Username:</label><input type="text" name="newUsername">
            <br><input type="submit" value="Change my username!">
        </form>
    </div>
</hmtl>

<?php

    function changeUsername() {

        global $conn;
        $errors = [];

        if ((empty($_POST['newUsername']))) {
            $errors[] = "Please fill in your details";
        }

        $result = $conn->query("SELECT * FROM logIn WHERE name='".$_POST['newUsername']."'");

        if ((mysqli_num_rows($result)) == 1) {
            $errors[] = "Sorry, this username is taken!";
            echo "2";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query("UPDATE logIn SET name='".$_POST['newUsername']."' WHERE name='".$_SESSION['username']."'");
            $_SESSION['username'] = $_POST['newUsername'];
            //header("Location: account.php");
            echo "all is ok";
        }
    }

    if (isset($_POST['submitted'])) {
        changeUsername();
    }