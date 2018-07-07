<?php

#This script gets the blog data from the database in order to display a list to the user


require("../core/init.php"); //require init file

$page_title = "Blogs";
include('../includes/header.inc.php'); //include header


//establish connection to database to fetch blog posts
try{
    //show blogs
    $q = "SELECT * FROM blog"; //get all blog entries
    $stmt = $pdo->prepare($q);
    $r = $stmt->execute();

    //if query successful, display view to user with blog post list
    if($r){
        if($stmt->rowCount() >= 1){
            $stmt->setFetchMode(PDO::FETCH_CLASS,'Blog'); //insert data in to new Blog class to be used in view
            //include view
            include('../views/blogs.html'); //the fetch while loop is situated inside the view if there are blog entries
        }else{
            throw new Exception('There are currently no blogs to display!');
        }

    }else{
        throw new Exception('Sorry, something went wrong. Please try again!');
    }
    

}catch(Exception $e){
    //dislpay errors to user
    echo $e->getMessage();
}

include('../includes/footer.inc.php'); //include footer


?>