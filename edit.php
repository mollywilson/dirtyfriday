<?php
$greeting = "Edit your order!";
include 'inc/connect.php';
include 'inc/header.php';
?>

<?php

if (isset($_POST['submitted'])) {

    $order_name= mysqli_real_escape_string($conn, $_POST['order_name']);
    $order_name = strip_tags($order_name);
    $order_number = mysqli_real_escape_string($conn, $_POST['order_number']);
    $order_number = strip_tags($order_number);
    $order_food2 = mysqli_real_escape_string($conn, $_POST['order_food2']);
    $order_food2 = strip_tags($order_food2);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = strip_tags($password);

    $sql = "SELECT * FROM logIn WHERE name='".$order_name."' AND password='".$password."'"; //sql command to test user password
    $result = mysqli_query($conn, $sql); //user exists

    $sql2 = "SELECT * FROM foodOrders WHERE orderID='" . $order_number . "'"; //test the order exists
    $result1 = mysqli_query($conn, $sql2); //order exists

    $sql3 = "UPDATE foodOrders SET food='".$order_food2."' WHERE orderID='".$order_number."'"; //sql to edit order

    if ((!empty($order_number)) && (!empty($order_food2)) && (!empty($password))) {

        if (mysqli_num_rows($result) > 0) {

            if (mysqli_num_rows($result1) > 0) {

                if (!mysqli_query($conn, $sql3)) {
                    die('Your order has NOT been deleted.');
                    } //end of nested if statement
                else {
                    header("location: index.php");
                }
            } else {
                echo "Sorry, this order doesn't exist!";
                }
        } else {
            echo "Username or password incorrect!";
            }
    } else {
        echo "Please fill in the details";
    }
}
?>

<html>
    <body>
    <div id="edit">
        <form method="post" action="edit.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Order Number:</label><input type="text" name="order_number">
            <br><label>New Order:</label><input type="text" name="order_food2">
            <br><label>Name:</label><input type="text" name="order_name">
            <br><label>Password:</label><input type="password" name="password">
            <br> <input type="submit" name="submit" value="Place my Order Again!">
        </form>
    </div>
    </body>
</html>
<?php include 'inc/ordersToday.php'; ?>