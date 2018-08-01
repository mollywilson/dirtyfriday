<?php
$greeting = "Place your order!";
include 'inc/connect.php';
include 'inc/header.php';

if (isset($_POST['submitted'])) {

    $order_name = mysqli_real_escape_string($conn, $_POST['order_name']);
    $order_name = strip_tags($order_name);
    $order_food = mysqli_real_escape_string($conn, $_POST['order_food']);
    $order_food = strip_tags($order_food);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = strip_tags($password);

    if ((!empty($order_name)) && (!empty($order_food)) && (!empty($password))) {

        $sql9 = "SELECT * FROM logIn WHERE name='" . $order_name . "' AND password='" . $password . "'";
        $result = mysqli_query($conn, $sql9);

        if (mysqli_num_rows($result) > 0) {

            $sql2 = "INSERT INTO foodOrders (name, food, date) VALUES 
                    ('$order_name', '$order_food', NOW())";

            if (!mysqli_query($conn, $sql2)) {
                die('Your order has NOT been placed.');
            } else {
                header("location: orders.php");
            }
        } else {
            echo "Your username or password is incorrect";
        }
    }
        else {
            echo "Please fill in your name and order";
    }
}
?>

<html>
    <body>
    <div id="order_form">
        <form method="post" action="index.php">
            <input type="hidden" name="submitted" value="true" />
            <br>Name: <input type="text" name="order_name">
            <br>Order: <input type="text" name="order_food">
            <br>Password: <input type="password" name="password">
            <br> <input type="submit" name="submit"  id="btn_sub" value="Place my Order!">
        </form>
    </div>
    <div id="search1">
        <form method="post" action="index.php">
            <input type="hidden" name="search" value="true" />
            Search: <input type="text" name="search_date" placeholder="yyyy-mm-dd">
            <input type="submit" name="searched" value="Search">
        </form>
    </div>
</body>

<?php

$pattern = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/';

if (isset($_POST['search'])) {
    $string = $_POST['search_date'];
    if (empty($string)) {
        echo "<br />\n" . "<br />\n";    } elseif (!preg_match($pattern, $string)) {
        echo "Please enter a date in the correct format!" . "<br />\n" . "<br />\n" ;
    } else {
        include 'search.php';
    }
}
    include 'inc/ordersToday.php';
?>
</html>
