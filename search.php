<html>
    <body>
        <div id="prev">
            <h2><i>Previous orders!</i></h2>
        </div>
        <div id="search">
        <?php

            function search() {

                echo "Orders from " . $_POST['search_date'] . ":<br />\n";

                global $conn;
                $result = $conn->query(sprintf("SELECT * FROM food_order WHERE date = '%s'", $_POST['search_date']));

                if ($result->num_rows == 0) {
                    echo "Sorry, we couldn't find any orders from " . $_POST['search_date'] . "!" . "<br />\n";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        echo $row["orderID"] . ". " . $row["name"] . " - " . $row["food"] . "<br />\n";
                    }
                }
            }

            search();
        ?>
        </div>
    </body>
</html>
