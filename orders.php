<html>
<?php
    $greeting = "Your order has been placed!";
    include 'inc/connect.php';
    include 'inc/header.php';
    include 'inc/today.php';
?>
        <form class="form text-center" action="edit.php">
            <input type="submit" class="btn btn-outline-dark" value="I've changed my mind!" />
        </form>

        <form class="form text-center" action="delete.php">
            <input type="submit" class="btn btn-outline-dark" value="Delete my order!" />
        </form>
</html>





