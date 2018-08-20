<?php
session_start();
session_destroy();
header('Location: /dirtyFriday/login.php');