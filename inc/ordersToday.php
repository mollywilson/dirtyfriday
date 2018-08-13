
<div id="orders">
    <?php

    $sql = "SELECT * FROM foodOrders WHERE date=CURDATE()"; //sql to select order from today
    $result = $conn->query($sql);

    echo "Today's Orders: " . "<br />\n";

    if ($result->num_rows > 0) { //if there are orders from today
        while ($row = $result->fetch_assoc()) { //
            echo $row["orderID"] . ". " . $row["name"] . " - " . $row["food"] .  "<br />\n";
        }//close while
    } //end of if today orders
    else {
        echo "Be the first to order!";
    } //end of today orders else
    echo "<br />\n";

    ?>

</div>
