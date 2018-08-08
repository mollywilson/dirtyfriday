<?php

    include 'inc/filter.php';
    //filter all the user inputs
    $username = filter($_POST['username']);
    $email = filter($_POST['email']);
    $password = filter($_POST['password']);
    $cpassword = filter($_POST['cpassword']);

    if ((!empty($username)) && (!empty($email)) && (!empty($password)) && (!empty($cpassword))) { //if form is not empty DO
        //echo "The form is submitted and not empty";

        $sql = "SELECT * FROM logIn WHERE name='".$username."'";
        $result = mysqli_query($conn, $sql);

        if (($result->num_rows) == 0) { //if username not taken DO
            //echo "The username is available!";

            $sql2 = "SELECT * FROM logIn WHERE email='".$email."'";
            $result1 = mysqli_query($conn, $sql2);

            if (($result1->num_rows == 0)) { //if email not taken DO
                //echo "This email is available";

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) { //if email is valid
                    //echo "This email is valid";

                    if ($password == $cpassword) { //if passwords match
                        //echo "The passwords match!" . $password . $cpassword;

                        $hash = password_hash($password, PASSWORD_BCRYPT); //TO HASH THE PASSWORD
                        //echo "Password: " . $hash;

                        $sql3 = "INSERT INTO logIn (name, email, password) VALUES ('$username', '$email', '$hash')";

                        if (!mysqli_query($conn, $sql3)) { //if user not created
                            die('Your user has NOT been created');
                        } //close user not created
                        else { //user is created
                            $_SESSION["username"] = $username;
                            header("location: index.php");
                            //echo "User has been created";
                        } //close user is created
                    } //close passwords match
                    else { //passwords don't match
                        echo "These passwords do not match";
                    } //close passwords dont match
                } //close if email valid
                else { //email not valid
                    echo "Sorry, this email is not valid";
                } //close email not valid
            }//close email not taken
            else { //if email taken
                echo "Sorry, this email address has already been used!";
            } //close email taken
        }//close if username not taken
        else { //the username is taken
            echo "Sorry, this username is taken!";
        } //close username is taken
    } //close if not empty
    else { //if empty (else)
        echo "Please fill in your details!";
    } //if empty close
} //close if submitted
else { //if not submitted (else)
    //echo "The form has not been submitted"; //if form submitted else do
} //close if submitted else
?>

<?php

    function signup()
    {

        global $conn;
        include 'inc/filter.php';
        $errors = [];
        $result = mysqli_query($conn, "SELECT * FROM logIn WHERE name='" . filter($_POST['username']) . "'");
        $result1 = mysqli_query($conn, "SELECT * FROM logIn WHERE email='".filter($_POST['username'])."'");
        $hash = password_hash(filter($_POST['password']), PASSWORD_BCRYPT);

        if ((empty(filter($_POST['username']))) || (empty(filter($_POST['email']))) || (empty(filter($_POST['password']))) || (empty(filter($_POST['cpassword'])))) {
            $errors[] = "Please fill in your details!";
        }

        if (($result->num_rows) == 1) {
            $errors[] = "This username is taken!";
        }

        if (($result1->num_rows == 1)) {
            $errors[] = "This email has already been used";
        }

        if (!filter_var(filter($_POST['email']), FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email";
        }

        if (filter($_POST['password']) == filter($_POST['cpassword'])) {
            $errors[] = "Your passwords do not match";
        }

        if (empty($errors)) {
            echo $errors[0];
        } else {
            mysqli_query($conn, "INSERT INTO logIn (name, email, password) VALUES ('".filter($_POST['username'])."', '".filter($_POST['email'])."', '$hash')");
            $_SESSION["username"] = filter($_POST['username']);
            header("location: index.php");
        }
    }


    if (isset($_POST['submitted'])) {
        signup();
    }
