<?php

#CRUD - EDIT PROJECT/BLOG

require('../core/init.php');

//return user to homepage if not logged in
if(!$logged_in){
    header('location: ./');
    exit();
}


//dependent on type of post being edited (project or blog), display the correct view
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $page_title = "Edit Post";
    include('../includes/header.inc.php');


    //get type and id of post
    $type = $_GET['type'];
    $id = $_GET['id'];

    //get data from database depending on type of data being edited
    if($type == 'blog'){
        try{

            $query = "SELECT * FROM blog WHERE blog_id = :id LIMIT 1";
            $stmt = $pdo->prepare($query);
            $result = $stmt->execute([':id' => $id]);

            if($result && $stmt->rowCount() == 1){

                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $blog = $stmt->fetch();
                include('../views/edit.html');

            }else{
                throw new Exception('The page you are trying to access does not exist');
            }

        }catch(Exception $e){
            display_error_page($e);
            exit();
        }
        

    }else if($type == 'project'){
        try{

            $query = "SELECT * FROM projects WHERE project_id = :id LIMIT 1";
            $stmt = $pdo->prepare($query);
            $result = $stmt->execute([':id' => $id]);

            if($result && $stmt->rowCount() == 1){
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $project = $stmt->fetch();
                include('../views/edit.html');
            }

        }catch(Exception $e){
            display_error_page($e);
            exit();
        }

    }else{
        header('location: logout.php');
    }

    include('../includes/footer.inc.php');

}


?>