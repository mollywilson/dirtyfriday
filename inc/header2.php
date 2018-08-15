<html>
<head>
    <title>Dirty Friday</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css"

</head>
<body>
<div class="container col-lg-12">
    <img src="<?php echo $image; ?>" alt="food_header" style=" width: 100%; height: 20%;" id="img">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">

        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="container">
            <div class="navbar-header">
                <span class="navbar-brand">Dirty<br>Fridays</span>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav ml-auto">
                    <li><a class="nav-link" href="requestPassword.php">Reset Password</a></li>
                    <li><a class="nav-link" href="signup.php">Sign Up</a></li>
                    <li><a class="nav-link" href="login.php">Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

</body>
</html>

<?php
include 'connect.php';
?>