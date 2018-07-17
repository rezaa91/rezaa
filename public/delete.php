<?php

#CRUD - DELETE BLOG/PROJECT

require('../core/init.php');

//redirect user if not logged in
if(!$logged_in){
    header('location: index.php');
    exit();
}


if($_SERVER['REQUEST_METHOD'] == "POST"){

    $type = $_GET['type']; //get type of post - project or blog
    $table_id = $type .'_id'; //name of id column in mysql table
    if(isset($_GET['id'])){
        $id = $_GET['id']; //get post id
    }

    //DELETE MULTIPLE ENTRIES - FROM PROJECTS.PHP AND BLOGS.PHP
    if( isset($_POST['check']) ){

        try{
            //get values from checked checkboxes and delete all those selected
            $checkbox_array = $_POST['check'];

            foreach($checkbox_array as $value){
                $query = "DELETE FROM $type WHERE $table_id = :id";
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute( [':id' => $value] );
            }

            header('location: ' . $type .'s.php');
            exit();            

        }catch(Exception $e){
            display_error_page($e);
            exit();
        }
    }







    //DELETE INDIVIDUALS POSTS - FROM PROJECT.PHP AND BLOGPOST.PHP
    

    try{

        //delete post from database
        $query = "DELETE FROM $type WHERE $table_id = :id ";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([':id' => $id]);

        //redirect user to post page if successfully deleted
        if($result){
            
            header('location: ' . $type . 's.php');
            exit();

        }else{ //if error deleting row from database...
            throw new Exception('We could not delete the post. Please try again.');
        }

    }catch(Exception $e){
        display_error_page($e);
    }

}


?>