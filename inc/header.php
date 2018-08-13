<html>
    <head>
        <link rel="stylesheet" href="CSS/dirtyfriday.css">
        <title>Dirty Friday</title>
    </head>
    <body>
        <div id="header">
            <a href="login.php">Log Out</a>
            <a href="account.php">Account</a>
            <a href="orders.php"> Orders </a>
            <a href="index.php"> Home </a>
            <a href="" id="title">Dirty Fridays: <i><?php echo $greeting; ?></i></a>
        </div>
    </body>
</html>

<?php
    include 'connect.php';
?>