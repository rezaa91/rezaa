<?php
#This script displays the view for the individual project

require("../core/init.php");

if($_SERVER['REQUEST_METHOD'] == "GET"){

    try{

        if(!isset($_GET['id'])){
            throw new Exception('The page you are looking for does not exist.');
        }

        $id = $_GET['id']; //get id - to use with projects in sql table


        //get individual project from sql table
        $query = "SELECT * FROM project WHERE project_id = :id LIMIT 1";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([':id' => $id]); //where id equals id in url

        //display view if successful query and only one row returned
        if($result && $stmt->rowCount() == 1){ 
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $project = $stmt->fetch(); //to be used in view

            //include relevent views
            $page_title = ucfirst($project->title);
            include('../includes/header.inc.php');
            include('../views/individual_project.html');
            include('../includes/footer.inc.php');

        }else{
            throw new Exception('The page you are looking for does not exist.');
        }

    }catch(Exception $e){
        display_error_page($e);
    }
}


?>