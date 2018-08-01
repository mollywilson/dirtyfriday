<html>
    <body>
        <div id="prev">
            <h2><i>Previous orders!</i></h2>
        </div>
        <div id="search">
            <?php
            include 'inc/connect.php';

            $search_date = $_POST['search_date'];

            $sql5 = "SELECT * FROM foodOrders WHERE date='".$search_date."'";
            $result = $conn->query($sql5);

            echo "Orders from " . $search_date . ":<br />\n";

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row["orderID"] . ". " . $row["name"] . " - " . $row["food"] .  "<br />\n";
                }
            } else {
                echo "Sorry, we couldn't find any orders from " . $search_date . "!" . "<br />\n";
            }
            echo "<br />\n";
            ?>
        </div>
    </body>
</html>