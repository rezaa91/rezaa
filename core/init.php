<?php

# This script is to be included by all scripts
# it loads all classes using the spl_autoload function
# begins the session
# stores the database connection

## created by Ali Issaee
## created: 29/06/18
## updated: 29/06/18



//class loading function
function class_loader($class){
    //require class if one directory deep
    if(file_exists('../classes/'.$class.'.php')){
        require('../classes/'.$class.'.php');
    }
}

spl_autoload_register(class_loader); //autoload classes

//get functions
$function_list = ['display_error_page'];

for($i = 0; $i<=function_list; $i++){
    //require functions if one directory deep
    if(file_exists('../functions/'.$function_list[$i].'.php')){
        require('../functions/'.$function_list[$i].'.php');
    }
}


session_start(); //start the session

$logged_in = null;

//check for user in the session
if(isset($_SESSION['user']) && (md5($_SERVER['HTTP_USER_AGENT']) == $_SESSION['agent']) ){
    $logged_in = true;
}else{
    $logged_in = false;
}



//uncomment the below code out when pushed to server
/*
**
error_reporting(0);
ini_set('display_errors',0);
*/

//display errors on localhost
error_reporting(E_ALL);
ini_set('display_errors',1);



//hide errors on server
/*
error_reporting(0);
ini_set('display_errors',0);
*/


require('config.php'); //require database configuration settings

//begin database connection
try{

    $pdo = new PDO('mysql:host=' . $_CONFIG['local']['host_name'] . ';dbname=' .$_CONFIG['local']['db_name'], $_CONFIG['local']['username'], $_CONFIG['local']['password'] );

}catch(PDOException $e){ //inform user if error connecting to database

    $page_title = "Error!";
    include('includes/header.inc.php');
    echo $e->getMessage();
    include('includes/footer.inc.php');

}


?>