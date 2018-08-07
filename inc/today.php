<div id="orders">
<?php

    echo "<br />\n" . "Today's Orders: " . "<br />\n";
    $result = $conn->query("SELECT * FROM foodOrders WHERE date=CURDATE()");

    if ($result->num_rows == 0) {
        echo "Be the first to order!";
    } else {
        $row = $result->fetch_assoc();
        echo $row["orderID"] . ". " . $row["name"] . " - " . $row["food"] . "<br />\n";
    }

?>
</div>
