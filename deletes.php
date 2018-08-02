<?php
$greeting = "Delete your order!";
include 'inc/connect.php';
include 'inc/header.php';
?>
    <html>
    <body>
    <form method="post" action="deletes.php">
        <input type="hidden" name="submitted" value="true" />
        <br>Order Number: <input type="text" name="order_number">
        <br> <input type="submit" name="submit" value="Delete my order!">
    </form>
    </body>
    </html>

<?php

if (isset($_POST['submitted'])) { //if form is submitted

    $order_number = mysqli_real_escape_string($conn, $_POST['order_number']); //prevent sql injection
    $order_number = strip_tags($order_number);

    $sql = "SELECT * FROM foodOrders WHERE orderID='".$order_number."' AND name='".$_SESSION["username"]."'"; //sql command to test if entry exists
    $result = mysqli_query($conn, $sql); //entry exists
    $sql2 = "DELETE FROM foodOrders WHERE orderID='".$order_number."'"; //sql command to delete entry

    if (!empty($order_number)) { //if order number not empty

        if (mysqli_num_rows($result) > 0) { //entry belongs to user

            if (!mysqli_query($conn, $sql2)) { //if cannot delete entry
                die('Your order has NOT been deleted.');
            } //end of cannot delete
            else {
                header("location: index.php");
            } //end of cannot delete else
        } //end of entry belongs to user
        else {
            echo "You can only delete your own order!";
        } //end of entry belongs else
    } //end of if empty
    else {
        echo "Please fill in your details";
    } //end of if empty else
}// end of if isset

include 'inc/ordersToday.php';
?>