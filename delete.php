<?php
$greeting = "Delete your order!";
include 'inc/connect.php';
include 'inc/header.php';
?>
    <html>
    <body>
    <div class="form">
        <form method="post" action="delete.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Order Number:</label><br><input type="text" name="id">
            <br><input type="submit" name="submit" value="Delete my order!">
        </form>
    </div>

    </body>
    </html>

<?php

    function delete() {

        global $conn;
        $errors = [];
        $result = $conn->query(sprintf("SELECT * FROM foodOrders WHERE orderID = '%s' AND name = '%s'", $_POST['id'], $_SESSION["username"]));

        if (empty($_POST['id'])) {
            $errors[] = "Please enter your order number!";
        }

        if (mysqli_num_rows($result) == 0) {
            $errors[] = "You can only delete your own order!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query(sprintf("DELETE FROM foodOrders WHERE orderID = '%s'", $_POST['id']));
            header("location: orders.php");
        }
    }

    if (isset($_POST['submitted'])) {
        delete();
    }

    include 'inc/today.php';
?>