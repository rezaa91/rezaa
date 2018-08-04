<?php

/**
 * This script shows dashboard data to administrators
 */

 require '../core/init.php';

 //redirect user if page accessed in error
 if(!$logged_in){
     $_SESSION['failure'] = 'Unauthorised access!';
     header('location: index.php');
     exit();
 }

?>