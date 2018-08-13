<?php
    include 'inc/connect.php';

    if (!isset($_SESSION['user_id'])) {
        // REDIRECT
        header("Location: http://molly.localhost/dirtyFriday/login.php");
    }

    $username = ($conn->query(sprintf("SELECT * FROM users WHERE id = '%s'", $_SESSION['user_id'])))->fetch_assoc();
    $greeting = "Place your order " . $username["name"] . "!";
    include 'inc/header.php';
?>
<html>
    <body>
    <div class="form">
        <form method="post" action="index.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Order:</label><br><input type="text" name="order">
            <br><input type="submit" name="submit"  id="btn_sub" value="Place my Order!">
        </form>
    </div>
    <div class="form">
        <form method="post" action="index.php">
            <input type="hidden" name="search" value="true" />
            <br><label>Search:</label><br><input type="text" name="search_date" placeholder="yyyy-mm-dd">
            <br><input type="submit" name="searched" value="Search">
        </form>
    </div>
</body>
</html>

<?php

    function order() {

        global $conn;
        $errors = [];
        include 'inc/filter.php';

        if (empty(filter($_POST['order']))) {
            $errors[] = "Please enter an order!";
        }

        $result = $conn->query(sprintf("SELECT * FROM food_order WHERE user_id = '%s' AND date = CURDATE()", $_SESSION['user_id']));

        if (mysqli_num_rows($result) == 1) {
            $errors[] = "Sorry, you have already ordered today, maybe you want to edit your order?";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query( sprintf("INSERT INTO food_order (user_id, food, date) VALUES ('%s', '%s', NOW())", $_SESSION['user_id'] , filter($_POST['order'])));
            header("location: orders.php");
            }
    }

    if (isset($_POST['submitted'])) {
        order();
    }
?>

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
