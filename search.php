<html>
    <body>
        <div class="container">
            <p class="text-center"><i>Previous orders!<br></i></p>
        <?php

            function search() {

                echo "Orders from " . $_POST['search_date'] . ":<br />\n";

                global $conn;
                $result = $conn->query(sprintf("SELECT * FROM users INNER JOIN food_order WHERE users.id = food_order.user_id AND date = '%s'", $_POST['search_date']));

                if ($result->num_rows == 0) {
                    echo "Sorry, we couldn't find any orders from " . $_POST['search_date'] . "!" . "<br />\n";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        echo $row["order_id"] . ". " . $row["name"] . " - " . $row["food"] . "<br />\n";
                    }
                }
            }

            search();
        ?>
        </div>
    </body>
</html>
