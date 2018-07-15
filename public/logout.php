<?php

#delete session and redirect user to home page
require('../core/init.php');

$_SESSION = [];
setcookie('PHPSESSID'); 
session_destroy();
header('location: /rezaa/public/index.php');

?>