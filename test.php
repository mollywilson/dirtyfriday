//creates a password reset table
<?php
$db->query( "CREATE TABLE IF NOT EXISTS reset (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255),
        selector CHAR(16),
        token CHAR(64),
        expires BIGINT(20)
    )");
?>

<html>
    <form method="post" action="password.php">
        <input type="hidden" name="submitted" value="true" />
        <br><label>Email:</label> <input type="text" name="email">
        <br><input type="submit" value="Send me an Email!">
    </form>
</html>
