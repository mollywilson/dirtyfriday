<?php
include 'inc/connect.php';
$greeting = "Place your order " . $_SESSION["username"] . "!";
include 'inc/header.php';

if (isset($_POST['submitted'])) {

    $order = mysqli_real_escape_string($conn, $_POST['order']);
    $order = strip_tags($order);

    if (!empty($order)) {

            $sql2 = "INSERT INTO foodOrders (name, food, date) VALUES 
                    ('".$_SESSION['username']."', '$order', NOW())";

            if (!mysqli_query($conn, $sql2)) {
                die('Your order has NOT been placed.');
            } else {
                header("location: orders.php");
            } //end of if order placed else
        } //end of if empty
        else {
            echo "Please fill in your name and order";
    } //end of if empty else
} //end of isset
?>

<html>
    <body>
    <div id="order_form">
        <form method="post" action="index.php">
            <input type="hidden" name="submitted" value="true" />
            <br>Order: <input type="text" name="order">
            <input type="submit" name="submit"  id="btn_sub" value="Place my Order!">
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
