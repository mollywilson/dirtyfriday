<html>
<?php
    $greeting = "Your order has been placed!";
    include 'inc/connect.php';
    include 'inc/header.php';
    include 'inc/today.php';
?>
        <form class="form" action="edit.php">
            <input type="submit" value="I've changed my mind!" />
        </form>

        <form class="form" action="delete.php">
            <input type="submit" value="Delete my order!" />
        </form>
</html>





