<?php
    $image = "pics/burger_banner.jpg";
    include 'inc/header.php';
?>

<html>
<body>
    <div class="container fill text-body col-lg-12 bg-light">
        <?php include 'inc/header1.php'; ?>
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
                    $result = $conn->query(sprintf("SELECT * FROM users INNER JOIN food_order WHERE users.id = food_order.user_id AND date = '%s'", $_SESSION['search_date']));

                    if ($result->num_rows == 0) {
                        echo "Sorry, we couldn't find any orders from " . $_SESSION['search_date'] . "!" . "<br />\n";
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            echo $row["order_id"] . ". " . $row["name"] . " - " . $row["food"] . "<br />\n" . "<br />\n";
                        }
                    }
                }
                search();
                ?>
        </div>
        </div> <!-- search results -->
        <?php include 'inc/footer.php'; ?>
    </div>
</body>
</html>
