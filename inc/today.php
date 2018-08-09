
<?php
    echo "<div class='p1'><br />\n" . "Today's Orders: " . "<br />\n</div>";
    $result = $conn->query("SELECT * FROM food_order WHERE date = CURDATE()");

    if ($result->num_rows == 0) {
        echo "Be the first to order!";
    } else {
        while ($row = $result->fetch_assoc()) {
    ?> <div class="p1"> <?php echo $row["orderID"] . ". " . $row["name"] . " - " . $row["food"] . "<br />\n";
        }
    }
?></div>
