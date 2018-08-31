<?php
    include 'inc/OrderRepository.php';
    $image = "pics/chippy1_banner.jpg";
    $greeting = "Your order has been placed!";
    include 'inc/header.php';
    $orderRepository = new OrderRepository();
    $ordersResults = $orderRepository->getOrders();

?>

    <div class="container fill bg-light col-lg-12">
        <div class="row">
            <div class="col-lg-12 text-center"></div>
        </div> <!-- filler -->
        <div class="row">
            <div class="col-lg-12">
                <br><br><br><br>
                <div class="container text-center" id="today">
                    <p><u>Today's Orders:</u></p>

                    <?php if (count($ordersResults) === 0) { ?>
                        <p>Be the first to order!</p>
                    <?php } else { ?>
                        <ul style="list-style: none">
                            <?php foreach ($ordersResults as $order) {
                                if ($order['user_id'] === $_SESSION['user_id']) {
                                    echo sprintf("<li>%s - %s &nbsp;
                                    <a href=\"delete.php?order_id=%s\" class=\"btn btn-outline-danger\">Delete</a>
                                    <a href=\"edit.php?\" class=\"btn btn-outline-info\">Edit</a>
                                    </li>", $order['name'], implode(', ', $order['items']), $order['order_id'], $order['order_id']);
                                } else {
                                    echo sprintf("<li>%s - %s</li>", $order['name'], implode(', ', $order['items']));
                                }
                            }?>
                        </ul>

                    <?php } ?>
                </div>
            </div>
        </div> <!-- orders -->
        <?php include 'inc/footer.php'; ?>
