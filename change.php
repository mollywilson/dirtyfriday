<?php
    $greeting = "Change your Password";
    include 'inc/header2.php';
    include 'inc/connect.php';
?>

<html>
    <body>
        <form method="post" action="change.php">
            <input type="hidden" name="submitted" value="true" />
            <br><label>Username:</label> <input type="text" name="username">
            <br>Password: <input type="password" name="password">
            <br>Confirm Password: <input type="password" name="cpassword">
            <br> <input type="submit" value="Change my Password">
        </form>
    </body>
</html>

<?php
if (isset($_POST['submitted'])) { //IF ISSET

    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $name = strip_tags($name);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = strip_tags($password);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $cpassword = strip_tags($cpassword);

    if ((!empty($name)) && (!empty($password)) && !empty($cpassword)) { //IF NOT EMPTY

        if ($password == $cpassword) { //passwords match

            $sql = "SELECT * FROM logIn WHERE name='".$name."'"; //check order is theirs
            $result = mysqli_query($conn, $sql); //user exists

            $hash = password_hash($password, PASSWORD_BCRYPT); //TO HASH THE PASSWORD

            $sql2 = "UPDATE logIn SET password='".$hash."' WHERE name='".$name."'"; //sql to edit order

            include 'inc/connect.php';

            if (mysqli_num_rows($result) > 0) { //if username exists

                if (!mysqli_query($conn, $sql2)) { //IF password cannot be changed
                    die('Your user has NOT been created');
                } //end of if cannot be changed
                else {
                    $_SESSION["username"] = $name;
                    echo "Password changed";
                    //header("location: index.php");
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