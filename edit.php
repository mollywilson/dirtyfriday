<?php
include 'inc/connect.php';
$greeting = "Edit your order " . $_SESSION["username"] . "!";
include 'inc/header.php';
?>

<?php

if (isset($_POST['submitted'])) { //if submitted

    $order_number = mysqli_real_escape_string($conn, $_POST['order_number']);
    $order_number = strip_tags($order_number);
    $order_food2 = mysqli_real_escape_string($conn, $_POST['order_food2']);
    $order_food2 = strip_tags($order_food2);

    $sql = "SELECT * FROM foodOrders WHERE name='".$_SESSION["username"]."' AND orderID='".$order_number."'"; //check order is theirs
    $result = mysqli_query($conn, $sql); //user exists

    $sql2 = "UPDATE foodOrders SET food='".$order_food2."' WHERE orderID='".$order_number."'"; //sql to edit order

    if ((!empty($order_number)) && (!empty($order_food2))) { //if not empty

        if (mysqli_num_rows($result) > 0) { //if username matches the order number

                if (!mysqli_query($conn, $sql2)) { //if cannot be editted
                    die('Your order has NOT been changed.');
                    } //end of if not changed
                else {
                    header("location: orders.php"); //if can be changed take to orders page
                } //end of if can change
            } //end of username matches order number
            else {
                echo "You can only edit your own order!";
                } //end of username order number else
        } //end of if not empty
        else {
            echo "Please fill in the details";
    } //end of if not empty else
} //end of if submitted
?>

<html>
    <body>
    <div id="edit">
        <form method="post" action="edit.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Order Number:</label><input type="text" name="order_number">
            <br><label>New Order:</label><input type="text" name="order_food2">
            <br> <input type="submit" name="submit" value="Place my Order Again!">
        </form>
    </div>
    </body>
</html>
<?php include 'inc/ordersToday.php'; ?>