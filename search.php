<?php
    $image = "pics/burger_banner.jpg";
    include 'inc/header.php';
?>
    <div class="container fill text-body col-lg-12 bg-light">
        <div class="row">
            <div class="col-lg-12"><br><br><br><br></div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <p><i>Previous orders!<br></i></p>
            </div>
    </div> <!-- previous orders -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <?php
                function search() {

                    echo "Orders from " . $_SESSION['search_date'] . ":<br />\n";

                    global $conn;
                    $orderQuery = $conn->query(sprintf("SELECT food_order.order_id, users.name FROM food_order INNER JOIN users ON users.id = food_order.user_id WHERE food_order.date = '%s'", $_SESSION['search_date']));
                    $ordersResults = array_map(function ($order) use ($conn){
                    $itemsQuery = $conn->query(sprintf("SELECT item FROM food_items WHERE order_id = %s", $order['order_id']));
                    $order['items'] = array_map(function ($item) {
                        return $item['item'];
                    }, $itemsQuery->fetch_all(MYSQLI_ASSOC));
                    return $order;
                }, $orderQuery->fetch_all(MYSQLI_ASSOC));

                if (count($ordersResults) === 0) {
                    echo sprintf("Sorry, there were no orders on %s!", $_SESSION['search_date']);
                } else {
                    foreach ($ordersResults as $order) {
                        echo sprintf("%s - %s" . "<br>\n", $order['name'], implode(', ', $order['items']));
                        }
                    }
                }
                search();
                ?>
        </div>
        </div> <!-- search results -->
        <?php include 'inc/footer.php'; ?>
