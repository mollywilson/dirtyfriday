<?php
    $greeting = "Account Details";
    include 'inc/header.php';
    include 'inc/connect.php';
    $result = $conn->query(sprintf("SELECT * FROM users WHERE id = '%s'", $_SESSION['user_id']));

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    }
    ?>

    <form class="form" action="username.php">
        <br><p><label>Username:</label> <?php echo $row['name'] ?></p>
        <br><input type="submit" class="btn1" name="changeName" value="Change my username!">
    </form>

    <form class="form" action="email.php">
        <br><p><label>Email Address:</label> <?php echo $row['email'] ?></p>
        <br><input type="submit" class="btn1" name="changeEmail" value="Change my email address!">
    </form>

    <form class="form" action="requestPassword.php">
        <br><label>Password: </label>
        <br><input type="submit" class="btn1" name="changePassword" value="Change my password!">
    </form>