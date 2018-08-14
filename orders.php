<html>
<?php
    $greeting = "Your order has been placed!";
    include 'inc/connect.php';
    include 'inc/header.php';
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <?php include 'inc/today.php'; ?>
                <div class="col-lg-12 text-center">
                <form class="form" action="edit.php">
                    <input type="submit" class="btn btn-outline-dark" value="I've changed my mind!" />
                    <input type="submit" class="btn btn-outline-dark" value="Delete my order!" />
                </form>
                </div>
            </div>
        </div>
    </div>
</html>

