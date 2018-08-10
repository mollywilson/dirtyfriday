<?php
include 'inc/connect.php';
$greeting = "Edit your order " . $_SESSION["username"] . "!";
include 'inc/header.php';
?>

<?php

    function edit() {

        global $conn;
        include 'inc/filter.php';
        $errors = [];

        if ((empty(filter($_POST['id']))) || (empty(filter($_POST['order'])))) { //if empty
            $errors[] = 'You must enter an ID and an order';
        }

        $result = $conn->query(sprintf("SELECT * FROM food_order WHERE user_id = '%s' AND order_id = '%s'", $_SESSION["user_id"], filter($_POST['order_id']))); //user exists

        if (mysqli_num_rows($result) == 0) {
            $errors[] = 'You can only edit your own order';
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query(sprintf("UPDATE food_order SET food = '%s' WHERE order_id = '%s'", filter($_POST['order']), filter($_POST['order_id'])));
            header("location: orders.php");
        }
    }

    if (isset($_POST['submitted'])) { //if submitted
        edit();
    }
?>

<html>
    <body>
        <form class="form" method="post" action="edit.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Order Number:</label><br><input type="text" name="order_id">
            <br><label>New Order:</label><br><input type="text" name="order">
            <br><input class="submit" type="submit" value="Place my Order Again!">
        </form>
    </body>
</html>
<?php include 'inc/today.php'; ?>