<html>
<?php
    $image = "pics/chippy1_banner.jpg";
    $greeting = "Your order has been placed!";
    include 'inc/header.php';
?>

    <div class="container fill bg-light col-lg-12">
        <?php include 'inc/header1.php'; ?>
        <div class="row">
            <div class="col-lg-12">
            <br><br><br><br>
            </div>
        </div> <!-- filler -->
        <div class="row">
            <div class="col-lg-12">
                <br><br><br><br>
            <?php include 'inc/today.php'; ?>
                <div class="col-lg-12 text-center">
                <form class="form" action="edit.php">
                    <input type="submit" class="btn btn-outline-dark" value="I've changed my mind!" />
                </form>
                <form class="form" action="delete.php">
                    <input type="submit" class="btn btn-outline-dark" value="Delete my order!" />
                </form>
                </div>
            </div>
        </div> <!-- orders -->
        <?php include 'inc/footer.php'; ?>
    </div>
</html>

