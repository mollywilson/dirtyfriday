<?php
    $image = "pics/chips_banner.jpg";
    include 'inc/header.php';
    include 'inc/OrderRepository.php';

    if (!isset($_SESSION['user_id'])) {
        // REDIRECT
        header("Location: login.php");
    }

    $username = ($conn->query(sprintf("SELECT * FROM users WHERE id = '%s'", $_SESSION['user_id'])))->fetch_assoc();
    $greeting = "Place your order " . $username["name"] . "!";
?>
    <div class="container fill text-center col-lg-12 bg-light">
        <div class="row">
            <div class="col-lg-7"></div>
            <div class="col-lg-5">
            <form class="text-center" method="post" action="index.php">
                <input type="hidden" name="search" value="true" />
                <label>Search:</label><input class="col-5 text-center" type="text" name="search_date" placeholder="yyyy-mm-dd">
                <input type="submit" class="btn btn-outline-dark" name="searched" value="Search">
            </form>
        </div>
        </div> <!-- search bar -->
        <div class="row">
                <div class="col-lg-7"> <br> </div>
                <div class="col-lg-5 text-danger text-center">
                    <?php
                    if (isset($_POST['search'])) {
                        searchDate();
                    } else {
                        echo "<br>\n";
                    }?>
                </div>
            </div> <!-- search errors -->
        <div class="row">
            <div class="col-lg-6">
                    <br><label>Order:</label>
            </div>
            <div class="col-lg-6"></div>
        </div>
        <div class="row">
            <div class="col-lg-6"> <!-- place order and today's order -->
                <form method="post" action="index.php">
                    <input type="hidden" name="submitted" value="true" />
                    <input class="col-6" type="text" name="order_1">
                    <input class="col-6" type="text" name="order_2">
                    <input class="col-6" type="text" name="order_3">
                    <input class="col-6" type="text" name="order_4">
                    <br><input type="submit" name="submit" class="btn btn-outline-dark" value="Place my Order!">
                </form>
            </div>
            <div class="col-lg-6">
                <p><u>Today's Orders</u></p>
                <?php
                $orderRepository = new OrderRepository();
                $ordersResults = $orderRepository->getOrders();

                if (count($ordersResults) === 0) {
                    echo "Be the first to order!";
                } else {
                    foreach ($ordersResults as $order) {
                        echo sprintf("%s - %s" . "<br>\n", $order['name'], implode(', ', $order['items']));
                    }
                }
                ?>
            </div>
        </div> <!-- order form and today's order -->
        <div class="row">
            <div class="col-lg-6 text-center text-danger">
                <?php
                if (isset($_POST['submitted'])) {
                order();
                } ?>
            </div>
            <div class="col-lg-6"></div>
        </div>
         <!-- order form errors -->
        <?php include 'inc/footer.php'; ?>

<?php

    function order()
    {

        global $conn;
        $errors = [];
        include 'inc/filter.php';

        if (empty(filter($_POST['order_1']))) {
            $errors[] = "Please enter an order!";
        } //check order is not completely empty

        $result = $conn->query(sprintf("SELECT * FROM food_order WHERE user_id = '%s' AND date = CURDATE()", $_SESSION['user_id'])); //mysql only order once

        if (mysqli_num_rows($result) == 1) {
            $errors[] = "Sorry, you have already ordered today," . "<br>\n" . "maybe you want to edit your order?";
        } //check that the user has not already ordered today

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query(sprintf("INSERT INTO food_order (user_id, date) VALUES ('%s', NOW())", $_SESSION['user_id']));
            $items = [];

            if (!empty($_POST['order_1'])) {
                $items[] .= $_POST['order_1'];
            }
            if (!empty($_POST['order_2'])) {
                $items[] .= $_POST['order_2'];
            }
            if (!empty($_POST['order_3'])) {
                $items[] .= $_POST['order_3'];
            }
            if (!empty($_POST['order_4'])) {
                $items[] .= $_POST['order_4'];
            }


            $result = $conn->query(sprintf("SELECT order_id FROM food_order WHERE user_id = '%s' AND date = CURDATE()", $_SESSION['user_id']));
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
            }
            $order_id = $row['order_id'];

            foreach ($items as $item) {
                $conn->query(sprintf("INSERT INTO food_items (order_id, item) VALUES ('%s', '%s')", $order_id, $item));
                header("location: orders.php");
            }
        }
    }
    function searchDate() {

        $errors = [];

        if (empty($_POST['search_date'])) {
            $errors[] = "Please enter a search date!";
        }

        if (!preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_POST['search_date'])) {
            $errors[] =  "Please enter a date in the correct format!" . "<br>\n" . "(yyyy-mm-dd)";
        }
            if (!empty($errors)) {
            echo $errors[0];
            } else {
            $_SESSION['search_date'] = $_POST['search_date'];
            header("Location: search.php");
        }
    }
    ?>