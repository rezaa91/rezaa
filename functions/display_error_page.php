<?php

#This function is used throughout the project
#It displays the full error page with useful information for the user

function display_error_page($error){
    $page_title = "Error!";

    //include error pages if one directory deep
    if(file_exists('../includes/header.inc.php')){
        include('../includes/header.inc.php');
        include('../views/error_page.html');
        include('../includes/footer.inc.php');
    }
}



?>