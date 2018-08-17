<?php
    $image = "pics/indian_banner.jpg";
    include 'inc/header.php';
    include 'inc/OrderRepository.php';
    $orderRepository = new OrderRepository();
    $ordersResults = $orderRepository->getOrders();
    $orderId = filter_input(INPUT_GET, 'order_id');
    $validator = filter_input(INPUT_GET, 'validator');
?>


<html>
<body>
<div class="container fill col-lg-12 bg-light">
    <?php include 'inc/header1.php'; ?>
    <div class="row">
        <div class="col-lg-12"><br><br><br><br></div>
    </div>
    <div class="row">
        <div class="col-lg-6 text-center">
            <br><label>New Order:</label><br>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 text-center">
            <form class="form" method="post" action="edit.php">
                <input type="hidden" name="submitted" value="true" />
                <?php if (count($ordersResults) === 0) {
                    echo "shouldn't be on this page at all";
                } else {
                    $selectQuery = mysqli_query($conn, sprintf("SELECT * FROM food_items WHERE order_id = '%s'", $orderId));
                    foreach ($selectQuery as $item) { ?>
                        <input class="col-6" type="text" value="<?php echo $item['item']; ?>" name="order_1"><br>
                    <?php } ?>
                     <input class="btn btn-outline-dark" type="submit" value="Place my Order Again!">
                    </form>
                    <?php }
                ?>
        </div>
        <div class="col-lg-6">
            <div class="container text-center" id="today">
                <p><u>Today's Orders:</u></p>
                <?php
                if (count($ordersResults) === 0) {
                    echo "Be the first to order!";
                } else {
                    foreach ($ordersResults as $order) {
                        echo sprintf("%s - %s" . "<br>\n", $order['name'], implode(', ', $order['items']));
                    }
                } ?>
            </div>
        </div>
    </div> <!-- edit form and today's orders -->
    <div class="row">
        <div class="col-lg-6 text-center text-danger">
            <?php
            if (isset($_POST['submitted'])) { //if submitted
                edit();
            }
            ?>
        </div>
    </div> <!-- errors -->
    <?php include 'inc/footer.php'; ?>
</div>
</body>
</html>

<?php
    function edit() {

        global $orderId;
        global $conn;
        include 'inc/filter.php';

        if (empty(filter($_POST['order_1']))) {
            $errors[] = "Please enter an order!";
        } //check order is not completely empty

        echo $orderId;

        $deleteOrder = sprintf("DELETE FROM food_order WHERE order_id = '%s'", $orderId);
        $deleteItem = sprintf("DELETE FROM food_order WHERE order_id = '%s'", $orderId);

        if (!mysqli_query($conn, $deleteOrder)) {
            $errors[] = "Order cannot be deleted";
        }

        if (!mysqli_query($conn, $deleteItem)) {
            $errors[] = "Items cannot be deleted";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query(sprintf("INSERT INTO food_order (user_id, date) VALUES ('%s', NOW())", $_SESSION['user_id']));
            $items = [];

            if (!empty($_POST['order_1'])) {
                $items[] .= $_POST['order_1'];
            }
//            if (!empty($_POST['order_2'])) {
//                $items[] .= $_POST['order_2'];
//            }
//            if (!empty($_POST['order_3'])) {
//                $items[] .= $_POST['order_3'];
//            }
//            if (!empty($_POST['order_4'])) {
//                $items[] .= $_POST['order_4'];
//            }

//            $result = $conn->query(sprintf("SELECT order_id FROM food_order WHERE user_id = '%s' AND date = CURDATE()", $_SESSION['user_id']));
//            if ($result->num_rows == 1) {
//                $row = $result->fetch_assoc();
//            }
//            $order_id = $row['order_id'];

            foreach ($items as $item) {
                $conn->query(sprintf("INSERT INTO food_items (order_id, item) VALUES ('%s', '%s')", $orderId, $item));
                //header("location: orders.php");
            }
        }
    }
    ?>