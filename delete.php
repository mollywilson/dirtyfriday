<?php
$greeting = "Delete your order!";
include 'inc/connect.php';
include 'inc/header.php';
?>
    <html>
    <body>
    <form method="post" action="delete.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Order Number:</label><br><input type="text" name="id">
        <br><input type="submit" name="submit" value="Delete my order!">
    </form>
    </body>
    </html>

<?php

    function delete() {

        global $conn;
        $errors = [];
        $result = mysqli_query($conn, "SELECT * FROM foodOrders WHERE orderID='".$_POST['id']."' AND name='".$_SESSION["username"]."'");

        if (empty($_POST['id'])) {
            $errors[] = "Please enter your order number!";
        }

        if (mysqli_num_rows($result) == 0) {
            $errors[] = "You can only delete your own order!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            mysqli_query($conn, "DELETE FROM foodOrders WHERE orderID='".$_POST['id']."'");
            header("location: orders.php");
        }
    }

    if (isset($_POST['submitted'])) {
        delete();
    }

    include 'inc/today.php';
?>