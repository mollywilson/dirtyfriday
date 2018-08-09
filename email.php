<?php
$greeting = "Update my Email Address";
include 'inc/header.php';
include 'inc/connect.php';
?>

    <hmtl>
        <div class="form">
            <form method="post">
                <input type="hidden" name="submitted" value="true" />
                <br><label>New Email Address:</label>
                <br><input type="text" name="newEmail">
                <br><input type="submit" value="Update my Email Address!">
            </form>
        </div>
    </hmtl>

<?php

function changeEmail() {

    global $conn;
    include 'inc/filter.php';
    $errors = [];

    if ((empty(filter($_POST['newEmail'])))) {
        $errors[] = "Please fill in your details";
    }

    $result = $conn->query(sprintf("SELECT * FROM logIn WHERE email = '%s'", filter($_POST['newEmail'])));

    if ((mysqli_num_rows($result)) == 1) {
        $errors[] = "Sorry, this email address is taken!";
    }

    if (!filter_var(filter($_POST['newEmail']), FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        $conn->query("UPDATE logIn SET email = '%s' WHERE name = '%s'", filter($_POST['newEmail']), $_SESSION['username']));
        header("Location: account.php");
    }
}

if (isset($_POST['submitted'])) {
    changeEmail();
}