<?php
$greeting = "Change my Password!";
include 'inc/header2.php';
include 'inc/connect.php';

?>

    <html>
    <form method="post" action="requestPassword.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Name:</label> <input type="text" name="username">
        <br><label>Email:</label> <input type="text" name="email">
        <br><input type="submit" value="Send me an Email!">
    </form>
    </html>

<?php

function requestPassword() {

    global $conn;
    include 'inc/filter.php';
    $errors = [];
    $email = filter($_POST['email']);
    $result = $conn->query("SELECT * FROM logIn WHERE name='".filter($_POST['username'])."' AND email='".filter($_POST['email'])."'");
    $email_hash = password_hash(filter($_POST['email']), PASSWORD_BCRYPT);
    $link = "http://molly.localhost/dirtyFriday/resetPassword.php?key=".$email_hash."";
    $_SESSION["email"] = filter($_POST['email']);

    if ((empty(filter($_POST['username']))) || (empty(filter($_POST['email'])))) {
        $errors[] = "Please enter your username and email address";
    }

    if (mysqli_num_rows($result) == 0) {
        $errors[] = "Your username or password is incorrect";
    }

    if (!empty($errors)) {
        echo $errors[0];
    } else {
        mail("$email", 'Dirty Fridays: Forgot my Password', "Please click the link to change your password!" . "$link");
        echo "Your email has been sent!";
    }
}

if (isset($_POST['submitted'])) {
    requestPassword();
}

//END OF THE ORIGINAL THAT WORKS!!!! ---------------------------------------------------------------------------------
?>


<?php
$greeting = "Change my Password!";
include 'inc/header2.php';
include 'inc/connect.php';

?>

    <html>
    <form method="post" action="requestPassword.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Name:</label> <input type="text" name="username">
        <br><label>Email:</label> <input type="text" name="email">
        <br><input type="submit" value="Send me an Email!">
    </form>
    </html>


<?php
// Create tokens
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

$url = sprintf('%sreset.php?%s', ABS_URL, http_build_query([
    'selector' => $selector,
    'validator' => bin2hex($token)
]));

// Token expiration
$expires = new DateTime('NOW');
$expires->add(new DateInterval('PT01H')); // 1 hour

// Delete any existing tokens for this user
$this->db->delete('password_reset', 'email', $user->email);

// Insert reset token into database
$insert = $this->db->insert('password_reset',
    array(
        'email'     =>  $user->email,
        'selector'  =>  $selector,
        'token'     =>  hash('sha256', $token),
        'expires'   =>  $expires->format('U'),
    )
);

$to = $user->email;

// Subject
$subject = 'Your password reset link';

// Message
$message = '<p>We recieved a password reset request. The link to reset your password is below. ';
$message .= 'If you did not make this request, you can ignore this email</p>';
$message .= '<p>Here is your password reset link:</br>';
$message .= sprintf('<a href="%s">%s</a></p>', $url, $url);
$message .= '<p>Thanks!</p>';

// Headers
$headers = "From: " . ADMIN_NAME . " <" . ADMIN_EMAIL . ">\r\n";
$headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";
$headers .= "Content-type: text/html\r\n";

// Send email
$sent = mail($to, $subject, $message, $headers);

//END OF EXPERIMENTAL REQUEST PASSWORD -----------------------------------------------------------------------------
?>

<?php
    $greeting = "Change my Password";
    include 'inc/header2.php';
    include 'inc/connect.php';
?>

    <html>
    <body>
    <form method="post" action="resetPassword.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Password:</label><br><input type="password" name="password">
        <br><label>Confirm Password:</label><br><input type="password" name="confirm">
        <br><input type="submit" value="Change my Password">
    </form>
    </body>
    </html>

<?php

    function resetPassword() {

        global $conn;
        include 'inc/filter.php';
        $errors = [];

        if ((empty(filter($_POST['password']))) || empty(filter($_POST['confirm']))) {
            $errors[] = "Please type a password!";
        }

        if (filter($_POST['password']) != filter($_POST['confirm'])) {
            $errors[] = "Your passwords must match!";
        }

        if (!empty($errors)) {
            echo $errors[0];
        } else {
            $hash = password_hash(filter($_POST['password']), PASSWORD_BCRYPT);
            $conn->query("UPDATE logIn SET password='".$hash."' WHERE email='".$_SESSION["email"]."'");
            header("location: login.php");
        }
    }

    if (isset($_POST['submitted'])) {
        resetPassword();
    }
    //END OF ORIGINAL RESET PASSWORD -------------------------------------------------------------------------------
?>


