<?php
include 'inc/connect.php';
$greeting = "Place your order " . $_SESSION["username"] . "!";
include 'inc/header.php';

function order() {

    global $conn;
    $errors = [];
    include 'inc/filter.php';

    if (empty(filter($_POST['order']))) {
        $errors[] = "Please enter an order!";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        mysqli_query($conn, "INSERT INTO foodOrders (name, food, date) VALUES ('".$_SESSION['username']."', '".filter($_POST['order'])."', NOW())");
        header("location: orders.php");
    }
}

if (isset($_POST['submitted'])) {
    order();
}
?>
<?php
include 'inc/connect.php';
$greeting = "Place your order " . $_SESSION["username"] . "!";
include 'inc/header.php';

if (isset($_POST['submitted'])) {

    include 'inc/filter.php';

    $order = filter($_POST['order']);

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
