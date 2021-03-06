<?php
    $image = "pics/chicken_banner.jpg";
    include 'inc/header.php';
?>

    <div class="container fill text-center bg-light col-lg-12">
        <form method="post">
            <input type="hidden" name="submitted" value="true" />
            <br><label>New Username:</label>
            <br><input class="col-3" type="text" name="newUsername">
            <br><input class="btn btn-outline-dark" type="submit" value="Change my Username!">
        </form>


<?php

function changeUsername() {

    global $conn;
    include 'inc/filter.php';
    $errors = [];

    if ((empty(filter($_POST['newUsername'])))) {
        $errors[] = "Please enter your username!";
    }

    $result = $conn->query(sprintf("SELECT * FROM users WHERE name = '%s'", filter($_POST['newUsername'])));

    if ((mysqli_num_rows($result)) == 1) {
        $errors[] = "Sorry, this username is taken!";
    }


    if (!empty($errors)) {
        echo $errors[0];
    } else {
        $conn->query(sprintf("UPDATE users SET name = '%s' WHERE id = '%s'", filter($_POST['newUsername']), $_SESSION['user_id']));
        header("Location: account.php");
    }
} ?>

        <div class="container text-center text-danger">
            <?php
            if (isset($_POST['submitted'])) {
                changeUsername();
            } ?>
        </div>
        <?php include 'inc/footer.php'; ?>