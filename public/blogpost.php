<?php

#This script handles and returns view which displays each individual blog information
require('../core/init.php');

if($_SERVER['REQUEST_METHOD'] == "GET"){

    $id = $_GET["id"]; //get id from url
    
    //get blog information from database using id from url
    $q = "SELECT * FROM blog WHERE blog_id = :id";
    $stmt = $pdo->prepare($q);
    $r = $stmt->execute([':id' => $id]);

    if($r){ 
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $blog = $stmt->fetch(); //to use in view


        $page_title = $blog->title; //set title to blog title

        //include views
        include('../includes/header.inc.php');
        include('../views/blogpost.html');
        include('../includes/footer.inc.php');
    }

}else{
    header('location: index.php');
    exit();
}


?>