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
        $query = "SELECT * FROM blog WHERE title LIKE :inputted_data ORDER BY blog_id DESC"; //get all relevant logs newest to oldest
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([':inputted_data' => '%'.$search_request.'%']);

        if($result && $stmt->rowCount() > 0){ //if successful result returned - display blogs to user
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Blog'); //insert data in to new Blog instance 
            $blogs = true; //flag var - set to true so will be displayed in view

        }else{
            throw new Exception('Sorry, we could not find what you were looking for. <a href="./blogs.php">Go back</a>');
        }

    }catch(Exception $e){
        //display errors to user
        $error = $e->getMessage();
    }



}else if($_SERVER['REQUEST_METHOD'] == "GET"){ //if page accessed via GET response

    //if page accessed with url variables to be used in pagination, redirect user to page with url variables inserted
    if(!$_GET['page']){
        header('location: blogs.php?page=1&s=0');
        exit();
    }

    //establish connection to database to fetch blog posts
    try{
        #pagination
        //get total number of blogs
        $query = "SELECT COUNT(blog_id) FROM blog";
        $result = $pdo->query($query);
        $total_blogs = $result->fetchColumn();

        //total to display per page
        $total_per_page = 8;

        //total pages
        $total_pages = ceil($total_blogs / $total_per_page);

        //get page number and start point
        $page_number = $_GET['page'];
        $start = $_GET['s'];



        //show blogs
        $q = "SELECT * FROM blog ORDER BY blog_id DESC LIMIT $start,$total_per_page"; //get all blog entries, newest to oldest
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute();

        //if query successful, fetch data to display in view
        if($r){
            if($stmt->rowCount() > 0){ //if 1 or more records returned - fetch data to display in view

                $stmt->setFetchMode(PDO::FETCH_CLASS,'Blog'); //insert data in to new Blog instance to be used in view
                $blogs = true; //flag variable to be used in view
                $pagination = true; //flag variable - show pagination if set to true


            }else{ //inform user if no blogs yet to display

                $blogs = false; //flag variable to be used in view
                throw new Exception('There are currently no blogs to display.');

            }
            

        }else{
            throw new Exception('Sorry, something went wrong. Please try again!');
        }
        

    }catch(Exception $e){
        //dislpay errors to user
        $error = $e->getMessage();
    }
}

//include view
include('../views/blogs.html'); //the fetch while loop is situated inside the view if there are blog entries
include('../includes/footer.inc.php');


?>