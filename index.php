<?php
    include 'inc/header.php';
    $image = "pics/chips_banner.jpg";

    if (!isset($_SESSION['user_id'])) {
        // REDIRECT
        header("Location: http://molly.localhost/dirtyFriday/login.php");
    }

    $username = ($conn->query(sprintf("SELECT * FROM users WHERE id = '%s'", $_SESSION['user_id'])))->fetch_assoc();
    $greeting = "Place your order " . $username["name"] . "!";
?>
<html>
    <body>
    <div class="container fill text-center col-lg-12 bg-light">
        <?php include 'inc/header1.php'; ?>
        <div class="row">
            <div class="col-lg-7"></div>
            <div class="col-lg-5">
            <form class="text-center" method="post" action="index.php">
                <input type="hidden" name="search" value="true" />
                <label>Search:</label><input class="col-5 text-center" type="text" name="search_date" placeholder="yyyy-mm-dd">
                <input type="submit" class="btn btn-outline-dark" name="searched" value="Search">
            </form>
        </div>
        </div> <!-- search bar -->
        <div class="row">
                <div class="col-lg-7"> <br> </div>
                <div class="col-lg-5 text-danger text-center">
                    <?php
                    if (isset($_POST['search'])) {
                        searchDate();
                    } else {
                        echo "<br>\n";
                    }?>
                </div>
            </div> <!-- search errors -->
        <div class="row">
            <div class="col-lg-6"> <!-- place order and today's order -->
                <form method="post" action="index.php">
                    <input type="hidden" name="submitted" value="true" />
                    <br><label>Order:</label><br><input class="col-6" type="text" name="order">
                    <br><input type="submit" name="submit" class="btn btn-outline-dark" value="Place my Order!">
                </form>
            </div>
                <div class="col-lg-6">
                    <?php include 'inc/today.php'; ?>
                </div>
            </div> <!-- order form and today's order -->
        <div class="row">
            <div class="col-lg-6 text-center text-danger">
                <?php
                if (isset($_POST['submitted'])) {
                order();
                } ?>
            </div>
            <div class="col-lg-6"></div>
        </div> <!-- order form errors -->
        <?php include 'inc/footer.php'; ?>
    </div>
    </body>
</html>

<?php

    function order() {

        global $conn;
        $errors = [];
        include 'inc/filter.php';

        if (empty(filter($_POST['order']))) {
            $errors[] = "Please enter an order!";
        }

        $result = $conn->query(sprintf("SELECT * FROM food_order WHERE user_id = '%s' AND date = CURDATE()", $_SESSION['user_id']));

        if (mysqli_num_rows($result) == 1) {
            $errors[] = "Sorry, you have already ordered today," . "<br>\n" . "maybe you want to edit your order?";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $conn->query( sprintf("INSERT INTO food_order (user_id, food, date) VALUES ('%s', '%s', NOW())", $_SESSION['user_id'] , filter($_POST['order'])));
            header("location: orders.php");
            }
    }

    function searchDate() {

        $errors = [];

        if (empty($_POST['search_date'])) {
            $errors[] = "Please enter a search date!";
        }

        if (!preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_POST['search_date'])) {
            $errors[] =  "Please enter a date in the correct format!";
        }
            if (!empty($errors)) {
            echo $errors[0];
            } else {
            $_SESSION['search_date'] = $_POST['search_date'];
            header("Location: search.php");
        }
    }
    ?>