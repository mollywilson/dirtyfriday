<?php
$greeting = "Sign Up";
include 'inc/connect.php';
include 'inc/header2.php'
?>

<html>
    <head>
        <link rel="stylesheet" href="css/dirtyFriday.css">
        <title>Dirty Friday</title>
    </head>
    <body>
        <form method="post" action="signup.php">
            <input type="hidden" name="submitted" value="true" />
            <br>Username: <input type="text" name="username">
            <br>Email: <input type="text" name="email">
            <br>Password: <input type="password" name="password">
            <br>Confirm Password: <input type="password" name="cpassword">
            <br> <input type="submit" value="Sign Me Up!">
        </form>
    </body>
</html>

<?php
    if (isset($_POST['submitted'])) { //IF ISSET

            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $username = strip_tags($username);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $email = strip_tags($email);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = strip_tags($password);
            $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
            $cpassword = strip_tags($cpassword);


            if ((!empty($username)) && (!empty($email)) && (!empty($password)) && (!empty($cpassword))) { //IF NOT EMPTY

                $sql4 = "SELECT * FROM logIn WHERE name='".$username."'";
                $result = mysqli_query($conn, $sql4);

                if (mysqli_num_rows($result) < 0) { //if username not exist

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                        $sql5 = "SELECT * FROM logIn WHERE email='".$email."'";
                        $result1 = mysqli_query($conn, $sql5);

                        if (mysqli_num_rows($result1) < 0) { //unique email
                            $vemail = $email;

                            if ($password == $cpassword) { //passwords match

                                //include 'connect.php';

                                $hash = password_hash($password, PASSWORD_BCRYPT); //TO HASH THE PASSWORD

                                $sql = "INSERT INTO logIn (name, email, password) VALUES 
                                ('$username', '$vemail', '$hash')"; //MYSQL COMMAND TO STORE DETAILS TO DATABASE

                                if (!mysqli_query($conn, $sql3)) { //IF DETAILS CANNOT BE STORED
                                    die('Your user has NOT been created');
                                } //end of IF CANNOT BE STORED
                                else {
                                    $_SESSION["username"] = $username;
                                    header("location: index.php");
                                } //END OF CANNOT BE STORED ELSE
                            } //end of passwords match
                            else {
                                echo "Your passwords do not match!";
                            } //end of passwords match else
                        } //end of unique email
                        else {
                            echo "Sorry, this email has already been used!";
                            } //end of unique email else
                    }//end of validate email
                    else {
                        echo "Please enter a valid email!";
                        } //end of valid email else
                }//end of username does not exist yet
                else {
                    echo "Sorry, this username is taken!";
                    }
                } //END OF IF NOT EMPTY
            else {
                echo "Please fill in your details!";
                } //END OF IF NOT EMPTY ELSE
            } // end of if isset
        ?>