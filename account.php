<?php
    $greeting = "Account Details";
    include 'inc/header.php';
    include 'inc/connect.php';
    $result = $conn->query("SELECT * FROM logIn WHERE name='".$_SESSION['username']."'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    }
    ?>

    <form action="username.php">
        <p>Username: <?php echo $row['name'] ?>
        <input type="submit" name="changeUsername" value="Change my username!"> </p>
    </form>

    <form action="email.php">
        <p>Email Address: <?php echo $row['email'] ?>
        <input type="submit" name="changeEmail" value="Change my email address!"> </p>
    </form>

    <form action="requestPassword.php">
        <p>Password:
        <input type="submit" name="changePassword" value="Change my password!"> </p>
    </form>
