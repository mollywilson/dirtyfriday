<?php
    $greeting = "Account Details";
    include 'inc/header.php';
    include 'inc/connect.php';
    $result = $conn->query(sprintf("SELECT * FROM logIn WHERE name = '%s'", $_SESSION['username']));

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    }
    ?>

    <p>Username: <?php echo $row['name'] ?></p>

    <form class="form" action="email.php">
        <br><p><label>Email Address:</label> <?php echo $row['email'] ?></p>
        <br><input type="submit" class="btn1" name="changeEmail" value="Change my email address!">
    </form>

    <form class="form" action="requestPassword.php">
        <br><label>Password: </label>
        <br><input type="submit" class="btn1" name="changePassword" value="Change my password!">
    </form>