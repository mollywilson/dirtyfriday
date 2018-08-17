<?php
    include 'inc/connect.php';

    function delete(mysqli $conn) {
        $deleteOrderId = $_GET['order_id'];
        mysqli_query($conn, sprintf("DELETE FROM food_order WHERE order_id = '%s'",  $deleteOrderId));
        mysqli_query($conn, sprintf("DELETE FROM food_items WHERE order_id = '%s'", $deleteOrderId));
        header("location: orders.php");
    }

    delete($conn);
    ?>
