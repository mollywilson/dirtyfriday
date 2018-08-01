
<div id="orders">
    <?php

    $sql = "SELECT * FROM foodOrders WHERE date=CURDATE()";
    $result = $conn->query($sql);

    echo "Today's Orders: " . "<br />\n";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row["orderID"] . ". " . $row["name"] . " - " . $row["food"] .  "<br />\n";
        }
    } else {
        echo "Be the first to order!";
    }

    echo "<br />\n";

    ?>

</div>
