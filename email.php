<?php
    $image = "pics/pizza_banner.jpg";
    include 'inc/header.php';
?>

    <div class="container fill col-lg-12 bg-light" id="today">
        <div class="row">
            <div class="col-lg-12 text-center">
                <form method="post">
                    <input type="hidden" name="submitted" value="true" />
                    <br><label>New Email Address:</label>
                    <br><input class="col-3" type="text" name="newEmail">
                    <br><input class="btn btn-outline-dark" type="submit" value="Update my Email Address!">
                </form>
            </div>
        </div> <!-- email update form -->
        <div class="row">
            <div class="col-lg-12 text-center text-danger">
                <?php
                if (isset($_POST['submitted'])) {
                changeEmail();
                } ?>
            </div>
        </div> <!-- errors -->
        <?php include 'inc/footer.php'; ?>

<?php
    function changeEmail() {

        global $conn;
        include 'inc/filter.php';
        $errors = [];

        if ((empty(filter($_POST['newEmail'])))) {
            $errors[] = "Please enter your email address!";
        }

        $result = $conn->query(sprintf("SELECT * FROM users WHERE email = '%s'", filter($_POST['newEmail'])));

        if ((mysqli_num_rows($result)) == 1) {
            $errors[] = "Sorry, this email address is taken!";
        }

        if (!filter_var(filter($_POST['newEmail']), FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query(sprintf("UPDATE users SET email = '%s' WHERE id = '%s'", filter($_POST['newEmail']), $_SESSION['user_id']));
            header("Location: account.php");
        }
    }
