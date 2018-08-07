<?php
include 'inc/connect.php';
$greeting = "Edit your order " . $_SESSION["username"] . "!";
include 'inc/header.php';
?>

<?php

    function edit() {

        global $conn;
        include 'inc/filter.php';
        $id = filter($_POST['id']);
        $order = filter ($_POST['order']);

        $errors = [];

        if ((empty($id)) || (empty($order))) { //if empty
            $errors[] = 'You must enter an ID and an order';
        }

        $sql = "SELECT * FROM foodOrders WHERE name='".$_SESSION["username"]."' AND orderID='".$id."'"; //check order is theirs
        $result = mysqli_query($conn, $sql); //user exists

        if (mysqli_num_rows($result) == 0) {
            $errors[] = 'You can only edit your own order';
        }

        $sql2 = "UPDATE foodOrders SET food='".$order."' WHERE orderID='".$id."'"; //sql to edit order

        if (!empty($errors)) {
            //foreach ($errors as $error):
            //echo $error;
            //endforeach;
            echo $errors[0];
            }

            else {
                mysqli_query($conn, $sql2);
                header("location: orders.php");
            }
        }

    if (isset($_POST['submitted'])) { //if submitted
        edit();
    }
?>

<html>
    <body>
    <div id="edit">
        <form method="post" action="edit.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Order Number:</label><br><input type="text" name="id">
            <br><label>New Order:</label><br><input type="text" name="order">
            <br><input type="submit" name="submit" value="Place my Order Again!">
        </form>
    </div>
    </body>
</html>
<?php include 'inc/ordersToday.php'; ?>