<?php

#This script gets the blog data from the database in order to display a list to the user


require("../core/init.php");

$page_title = "Blogs";
include('../includes/header.inc.php');



if($_SERVER['REQUEST_METHOD'] == "POST"){ //if page accessed via search bar post

    //get the user inputted data
    $search = new Validate(); //new instance of Validate class
    $search_request = $search->isStr($_POST['search']); //store user inputted data in var

    
    //find all blogs in database with a title similar to the inputted information
    try{
        $query = "SELECT * FROM blog WHERE title LIKE :inputted_data";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([':inputted_data' => '%'.$search_request.'%']);

        if($result && $stmt->rowCount() > 0){ //if successful result returned - display blogs to user
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Blog'); //insert data in to new Blog instance 
            //include view
            include('../views/blogs.html');

        }else{
            throw new Exception('Sorry, we could not find what you were looking for. <a href="./blogs.php">Go back</a>');
        }

    }catch(Exception $e){
        //display errors to user
        $error = $e->getMessage();
        include('../views/blogs.html');
    }



}else if($_SERVER['REQUEST_METHOD'] == "GET"){ //if page accessed via GET response

    //establish connection to database to fetch blog posts
    try{
        //show blogs
        $q = "SELECT * FROM blog"; //get all blog entries
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute();

        //if query successful, display view to user with blog post list
        if($r){
            if($stmt->rowCount() >= 1){
                $stmt->setFetchMode(PDO::FETCH_CLASS,'Blog'); //insert data in to new Blog instance to be used in view
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
        $error = $e->getMessage();
    }
}


include('../includes/footer.inc.php');


?>