<?php
if (isset($_POST['submitted'])) { //IF ISSET

    include 'inc/filter.php';

    $password = filter($_POST['password']);
    $confirm = filter($_POST['confirm']);

    if ((!empty($password)) && !empty($confirm)) { //IF NOT EMPTY

        if ($password == $confirm) { //passwords match

            $sql = "SELECT * FROM logIn WHERE email='".$_SESSION["email"]."'"; //check order is theirs
            $result = mysqli_query($conn, $sql); //user exists

            $hash = password_hash($password, PASSWORD_BCRYPT); //TO HASH THE PASSWORD

            $sql2 = "UPDATE logIn SET password='".$hash."' WHERE email='".$_SESSION["email"]."'"; //sql to edit order

            include 'inc/connect.php';

            if (mysqli_num_rows($result) == 1) { //if username exists

                if (!mysqli_query($conn, $sql2)) { //IF password cannot be changed
                    die('Your user has NOT been created');
                } //end of if cannot be changed
                else {
                    //echo "Password changed";
                    header("location: login.php");
                } //END OF CANNOT BE STORED ELSE
            }//end of if user exists
            else {
                echo "Username incorrect";
            } //end of username else
        } //end of passwords match
        else {
            echo "Your passwords do not match!";
        }//end of passwords match else
    } //END OF IF NOT EMPTY
    else {
        echo "Please fill in your details!";
    } //END OF IF NOT EMPTY ELSE
} // end of if isset
?>


