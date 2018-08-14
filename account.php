<?php
    $greeting = "Account Details";
    include 'inc/header.php';
    include 'inc/connect.php';
    $result = $conn->query(sprintf("SELECT * FROM users WHERE id = '%s'", $_SESSION['user_id']));

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    }
    ?>

    <form class="container text-center" action="username.php">
        <br><p>Username: <?php echo $row['name'] ?></p>
        <br><input type="submit" class="btn btn-outline-dark" name="changeName" value="Change my username!">
    </form>

    <form class="container text-center" action="email.php">
        <br><p class="text-center">Email Address: <?php echo $row['email'] ?></p>
        <br><input type="submit" class="btn btn-outline-dark" name="changeEmail" value="Change my email address!">
    </form>

    <form class="container text-center" action="requestPassword.php">
        <br><p class="text-center">Password: </p>
        <br><input type="submit" class="btn btn-outline-dark" name="changePassword" value="Change my password!">
    </form>