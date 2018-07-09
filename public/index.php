<?php

//require init file - connects database, begins session
require('../core/init.php');


//Check whether email subscription form posted and handle
if($_SERVER['REQUEST_METHOD'] == "POST"){
    //validate email address
    $validate = new Validate(); //new Validate instance obj
    $email = $validate->isEmail($_POST['email']); //check if valid email before posting to database

    //insert email into database if valid and not already submitted
    try{
        if($email){
            //check whether email is already in database
            $q = "SELECT email FROM email_marketing WHERE email = :email";
            $stmt = $pdo->prepare($q);
            $r = $stmt->execute([':email' => $_POST['email']]);

            if($r && $stmt->rowCount() == 0){ //if inputted email does not exist already in table, add to database
                $q = "INSERT INTO email_marketing(email) VALUES(:email)";
                $stmt = $pdo->prepare($q);
                $r = $stmt->execute([':email' => $_POST['email']]); //insert email in to database

                if($r){ //redirect user to homepage with cookie specifying successful message - if successfully inputted in to database
                    $_SESSION['success'] = "You have successfully subscribed for newsletters and updates"; //show successful message on index page after redirect
                    header('location: index.php');
                    exit();
                }else{ //if error inserting data - inform user
                    throw new Exception('Sorry, something went wrong. Please try again');
                }

            }else{ //if user inputted email already exists, inform user
                throw new Exception('The email supplied is already subscribed');
            }
            

        }else{ //throw exception if email invalid
            throw new Exception('Please input a valid email address'); 
        }

    }catch(Exception $e){
        echo $e->getMessage();
    }

}


//set page title and include relevent views
$page_title = "<Rezaa />";
include('../includes/header.inc.php');
include('../views/index.html'); //index page view
include('../includes/footer.inc.php');



?>