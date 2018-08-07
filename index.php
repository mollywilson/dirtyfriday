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
    include 'inc/today.php';
?>
</html>
