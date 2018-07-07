<?php

//require init file - connects database, begins session
require('../core/init.php');

//set page title and include relevent views
$page_title = "<Rezaa />";
include('../includes/header.inc.php');
include('../views/index.html'); //index page view
include('../includes/footer.inc.php');



?>