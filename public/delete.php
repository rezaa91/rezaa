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

            //delete checked rows from database and any images from directory
            foreach($checkbox_array as $value){
                $query = "SELECT image_path FROM $type WHERE $table_id = :id"; //select the image path data from selected row
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute([':id' => $value]);

                if($result){
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $stmt->fetch();
                    $image_path = $row['image_path']; //get the image path for individual row

                    $image = new File($image_path); //create new instance with image path as str arg
                    $image->delete_file(); //delete the image


                    //delete full row from database
                    $query = "DELETE FROM $type WHERE $table_id = :id";
                    $stmt = $pdo->prepare($query);
                    $result = $stmt->execute( [':id' => $value] );

                }
            }

            $_SESSION['success'] = $type . 's successfully deleted.';
            $url_extension = $type == 'blog' ? '?page=1&s=0' : ''; //blog url variables
            header('location: ' . $type .'s.php' . $url_extension);
            exit();            

        }catch(Exception $e){
            display_error_page($e);
            exit();
        }
    }





    

    //DELETE INDIVIDUALS POSTS - FROM PROJECT.PHP AND BLOGPOST.PHP
    try{

        //get the file path in order to delete file from dir
        $query = "SELECT image_path FROM $type WHERE $table_id = :id";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute( [':id' => $id] );

        if($result){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $image_path = $row['image_path']; //get the data from the image_path column, returns string

            $image = new File($image_path); //create new instance, pass the image_path str as arg
            $image->delete_file(); //delete file from database
        

            //delete post from database
            $query = "DELETE FROM $type WHERE $table_id = :id ";
            $stmt = $pdo->prepare($query);
            $result = $stmt->execute([':id' => $id]);

            //redirect user to post page if successfully deleted
            if($result){
                $_SESSION['success'] = $type . ' successfully deleted.';
                $url_extension = $type == 'blog' ? '?page=1&s=0' : ''; //blog url variables
                header('location: ' . $type . 's.php' . $url_extension);
                exit();

            }else{ //if error deleting row from database...
                throw new Exception('We could not delete the post. Please try again.');
            }

        }else{ //error deleting file from directory
            throw new Exception('Sorry, we could not delete the post. Please try again.');
        }


    }catch(Exception $e){
        display_error_page($e);
    }

}


?>