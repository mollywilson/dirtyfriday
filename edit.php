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

                    ?>
                <input type="hidden" name="order_id" value="<?=$orderId;?>">
                    <?php

                    $selectQuery = mysqli_query($conn, sprintf("SELECT * FROM food_items WHERE order_id = '%s'", $orderId));
                    foreach ($selectQuery as $item) { ?>
                        <input class="col-6" type="text" value="<?php echo $item['item']; ?>" name="items[<?= $item['item_id'];?>]"><br>
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

        foreach ($_POST['items'] as $k => $item) {
            $conn->query(sprintf(
                    "UPDATE food_items SET item = '%s' WHERE item_id = '%s'", $item, $k));

        }
        header("location: orders.php");
    }
    ?>