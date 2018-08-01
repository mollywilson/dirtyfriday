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
        <br>Name: <input type="text" name="order_name">
        <br>Password: <input type="password" name="password">
        <br> <input type="submit" name="submit" value="Delete my order!">
    </form>
    </body>
    </html>

<?php

if (isset($_POST['submitted'])) { //if form is submitted

    $order_number = mysqli_real_escape_string($conn, $_POST['order_number']); //prevent sql injection
    $order_number = strip_tags($order_number);
    $order_name = mysqli_real_escape_string($conn, $_POST['order_name']);
    $order_name = strip_tags($order_name);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = strip_tags($password);

    $sql6 = "SELECT * FROM foodOrders WHERE orderID='" . $order_number . "' AND name='".$order_name."'"; //sql command to test if entry exists
    $sql3 = "DELETE FROM foodOrders WHERE orderID='" . $order_number . "' AND name='" . $order_name . "'"; //sql command to delete entry
    $result = mysqli_query($conn, $sql6); //entry exists

    $sql9 = "SELECT * FROM logIn WHERE name='" . $order_name . "' AND password='" . $password . "'"; //sql command to test user password
    $result1 = mysqli_query($conn, $sql9); //user exists

    if (!empty($order_number) && !empty($order_name)) {

        if (mysqli_num_rows($result1) > 0) { //user exists

            if (mysqli_num_rows($result) > 0) { //entry exists

                if (!mysqli_query($conn, $sql3)) {
                    die('Your order has NOT been deleted.');
                } //end of nested if statement
                else {
                    header("location: index.php");
                }
                } else {
                    echo "This order doesn't exist!";
                }
                } else {
                    echo "Incorrect username or password!";
                }
        } else {
        echo "Please fill in your details";
    }
}// end of if isset

include 'inc/ordersToday.php';
?>