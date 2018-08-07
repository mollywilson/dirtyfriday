<?php
            if (!mysqli_query($conn, $sql2)) { //if cannot delete entry
                die('Your order has NOT been deleted.');
            } //end of cannot delete
            else {
                header("location: index.php");
            } //end of cannot delete else
        } //end of entry belongs to user
        else {
            echo "You can only delete your own order!";
        } //end of entry belongs else
    } //end of if empty
    else {
        echo "Please fill in your details";
    } //end of if empty else
}// end of if isset

include 'inc/today.php';
?>

<?php

    function delete() {

        global $conn;
        $errors = [];
        $result = mysqli_query($conn, "SELECT * FROM foodOrders WHERE orderID='".$_POST['id']."' AND name='".$_SESSION["username"]."'");

        if (empty($_POST['id'])) {
            $errors[] = "Please enter your order number!";
        }

        if (mysqli_num_rows($result) == 0) {
            $errors[] = "You can only delete your own order!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            mysqli_query($conn, "DELETE FROM foodOrders WHERE orderID='".$_POST['id']."'");
            //header("location: index.php");
            echo "order has been deleted";
        }
    }

    if (isset($_POST['submitted'])) {
        delete();
    }
?>

