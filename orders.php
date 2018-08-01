<html>
<?php
    $greeting = "Your order has been placed!";
    include 'inc/connect.php';
    include 'inc/header.php';
    include 'inc/ordersToday.php';
?>
    <div id="btn_edit">
        <form action="edit.php">
            <input type="submit" value="I've changed my mind!" />
        </form>
    </div>

    <div id="btn_delete">
        <form action="deletes.php">
            <input type="submit" value="Delete my order!" />
        </form>
    </div>
</html>





