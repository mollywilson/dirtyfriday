
<?php
    /*
    $errors = [];

    if (empty($_POST['email_address'])) {
        $errors[] = 'You must enter an email address';
    }

    // ...

    if (empty($errors)) {
        // everything's okay, let's insert into the database
    }

    ?>
One or more errors occurred:
<ul>
    <?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>
    <?php endforeach; ?>
</ul>
    */

//if (isset($_POST['submitted'])) { //if form is submitted


//        $username = filter($_POST['username']);
//        $password = filter($_POST['password']);
//
//        $dbpassword = "SELECT password FROM logIn WHERE name='".$username."'"; //if username exists
//        $result = mysqli_query($conn, $dbpassword);

//        if ((!empty($username)) && (!empty($password))) { //if form not empty

            if (mysqli_num_rows($result) > 0) { //if username exists
                $row = $result->fetch_array();
                    if (password_verify($password, $row['password'])) {
                        //echo "SUCCESS";
                        $_SESSION["username"] = $username;
                        header("Location: index.php");
                    }// end of password verify
            else {
                echo "Your username or password is incorrect";
            } // end of password verify else
        }// end of if username exists
            else {
                echo "Your username or password is incorrect";
            } //end of username exists else
        }//end of if not empty
        else {
            echo "Please fill in your details";
        }// end of if not empty else
    }// end of isset
?>

<?php

    function login() {

        $errors = [];
        $username = filter($_POST['username']);
        $password = filter($_POST['password']);
        $dbpassword = "SELECT password FROM logIn WHERE name='".$username."'"; //if username exists
        $result = mysqli_query($conn, $dbpassword);

        if ((empty($username)) && (empty($password))) {
            $errors[] = "You must enter your username and password";
        }

        if (mysqli_num_rows($result) == 0) {
            $row = $result->fetch_array();
            $errors[] = "Your username or password is incorrect";
        }

        if (!password_verify($password, $row['password'])) {
            $errors[] = "Your username or password is incorrect";
        }

        if (!empty($errors)) {
            echo $errors[0];
            }

        else {
            echo "form ok";
            //header("location: orders.php");
        }
    }

    if (isset($_POST['submitted'])) {
        login();
    }