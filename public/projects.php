<?php

require("../core/init.php");

$page_title = "projects";
include("../includes/header.inc.php");

try{

    //get all projects from database
    $query = "SELECT * FROM projects";
    $result = $pdo->query($query);

    if($result && $result->rowCount() > 0){
        //if projects stored in database, display in view
        $result->setFetchMode(PDO::FETCH_OBJ); //$project->fetch() to be used in the view
        $projects = true; //flag variable - set to true if there are projects in table. This is used in the view

    }else{
        //throw error message if no projects currently in database
        $projects = false; //flag variable - set to false if no projects yet to display. This is used in the view
        throw new Exception('There are currently no projects to display.');
    }


}catch(Exception $e){
    $error = $e->getMessage();
}


include("../views/projects.html");
include("../includes/footer.inc.php");

?>