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
            $conn->query( "INSERT INTO foodOrders (name, food, date) VALUES ('".$_SESSION['username']."', '".filter($_POST['order'])."', NOW())");
                header("location: orders.php");
            }
    }

    if (isset($_POST['submitted'])) {
        order();
    }
?>

<html>
    <body>
    <div id="order_form">
        <form method="post" action="index.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Order:</label><br><input type="text" name="order">
            <br><input type="submit" name="submit"  id="btn_sub" value="Place my Order!">
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
</html>

<?php

    function searchDate() {

        $errors = [];

        if (empty($_POST['search_date'])) {
            $errors[] = "Please enter a search date";
        }

        if (!preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_POST['search_date'])) {
            $errors[] =  "Please enter a date in the correct format!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            include 'search.php';
        }
    }

    if (isset($_POST['search'])) {
        searchDate();
    }

include 'inc/today.php';
