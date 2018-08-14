<?php
$greeting = "Delete your order!";
include 'inc/connect.php';
include 'inc/header.php';
?>
    <html>
    <body>
    <div class="container text-center">
        <div class="row">
            <form class="col-lg-6 text-center" method="post" action="delete.php">
                <input type="hidden" name="submitted" value="true" />
                <br><label>Order Number:</label><br><input class="col-6" type="text" name="order_id">
                <br><input class="btn btn-outline-dark" type="submit" name="submit" value="Delete my order!">
            </form>
            <div class="col-lg-6 text-center">
                <?php include 'inc/today.php'; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 text-center text-danger">
                <?php
                if (isset($_POST['submitted'])) {
                    delete();
                } ?>
            </div>
        </div>
    </div>

    </body>
    </html>

<?php

    function delete() {

        global $conn;
        $errors = [];
        $result = $conn->query(sprintf("SELECT * FROM food_order WHERE order_id = '%s' AND user_id = '%s'", $_POST['order_id'], $_SESSION["user_id"]));

        if (empty($_POST['order_id'])) {
            $errors[] = "Please enter your order number!";
        }

        if (mysqli_num_rows($result) == 0) {
            $errors[] = "You can only delete your own order!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query(sprintf("DELETE FROM food_order WHERE order_id = '%s'", $_POST['order_id']));
            header("location: orders.php");
        }
    } ?>



