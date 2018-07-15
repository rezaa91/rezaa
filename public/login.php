<?php

#This script logs in administrator and sets a login session in order for administrator to access the admin panel for CRUD functionality


require('../core/init.php');

//handle login script
if($_SERVER['REQUEST_METHOD'] == "POST"){

    //validate login data
    $validate = new Validate();
    $email = $validate->isEmail($_POST['email']);
    $password = $validate->isStr($_POST['pass']);


    //if passed validation, check to see login credentials exist in database
    try{

        $query = "SELECT * FROM admin WHERE email=:email && pass=SHA1(:pass)";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([':email' => $_POST['email'], ':pass' => $_POST['pass']]);

        //log administrator in if row exists in table and redirect to dashboard page
        if($result && $stmt->rowCount() == 1){
            //store user in session
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $user = $stmt->fetch();
            $_SESSION['user'] = $user; //store User instance in session in order for logged in user to traverse administrator pages of website
            $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']); //hash for user OS and browser for extra security

            //redirect to admin dashboard and exit script
            header('location: index.php');
            exit();
            

        }else{ //display message to user if row not found in database
            throw new Exception('The username and password entered do not match. Please try again.');
        }

    }catch(Exception $e){
        display_error_page($e);
        exit();
    }

}


$page_title = "Login";
include('../includes/header.inc.php');
include('../views/admin_login.html');
include('../includes/footer.inc.php');


?>