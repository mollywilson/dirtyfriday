<html>
    <head>
        <link rel="stylesheet" href="../css/custom.css">
    </head>
    <body>

    <div class="container text-center" id="today">
        <p><u>Today's Orders:</u></p>

        <?php
        $result = $conn->query("SELECT * FROM users INNER JOIN food_order WHERE users.id = food_order.user_id AND date = CURDATE()");

        if ($result->num_rows == 0) {
            echo "Be the first to order!";
        } else {
            while ($row = $result->fetch_assoc()) {
                echo $row["order_id"] . ". " . $row["name"] . " - " . $row["food"] . "<br />\n"; }} ?>
    </div>
    </body>
</html>