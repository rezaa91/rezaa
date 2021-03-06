<?php

#CRUD - CONFIRM EDIT CHANGES FROM BLOGS AND PROJECTS

require('../core/init.php');

//redirect user to homepage if accessed in error
if(!$logged_in){
    header('location: index.php');
    exit();
}


//update data in database
if($_SERVER['REQUEST_METHOD'] == "POST"){

    $type = $_GET['type']; //get type of post from url - blog or project
    $id = $_GET['id']; // get id from url

    try{

        //dependant on type (project or blog), validate data and insert in to database
        if($type == 'blog'){ //BLOG

            //validate data
            $validate = new Validate();
            $title = $validate->isStr($_POST['title']);
            $body = $validate->isStr($_POST['body']);

            //update data to database if form validation passed
            if($title && $body){

                //if user selected an image for upload, change this and delete the previous image
                if(!empty($_FILES['file']['name'])){

                    $query = "SELECT image_path FROM blog WHERE blog_id = :blog_id";
                    $stmt = $pdo->prepare($query);
                    $result = $stmt->execute([':blog_id' => $id]);

                    //delete the old file from directory
                    if($result){
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $stmt->fetch();
                        $image_path = $row['image_path'];

                        $image = new File($image_path);
                        $image->delete_file();
                    }

                    //upload the new file
                    $image = new File($_FILES['file']);
                    $image->upload_file();
                    $file_path = $image->get_file_name();

                    //update the database
                    $query = "UPDATE blog SET image_path = :image_path WHERE blog_id = :blog_id";
                    $stmt = $pdo->prepare($query);
                    $result = $stmt->execute([':image_path' => $file_path, ':blog_id' => $id]);

                }

                $query = "UPDATE blog SET title = :title, body = :body, updated_at = NOW() WHERE blog_id = :blog_id";
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute([ ':title' => $_POST['title'], ':body' => $_POST['body'], ':blog_id' => $id ]);

                //redirect user to updated blog page if successfully updated
                if($result){
                    $_SESSION['success'] = "Blog successfully updated.";
                    header("location: blogpost.php?id=$id");

                }else{//alert user if error updating data
                    throw new Exception('Sorry, something went wrong. Please try again.');
                }


            }else{ //failed form validation
                throw new Exception('Please fill in all the fields with the correct data.');
            }



        }elseif($type == 'project'){ //PROJECT

            //validate data
            $validate = new Validate();
            $title = $validate->isStr($_POST['title']);
            $aims = $validate->isStr($_POST['aims']);
            $process = $validate->isStr($_POST['process']);
            $outcome = $validate->isStr($_POST['outcome']);
            $link = $validate->isStr($_POST['link']);

            //update data to database if passed form validation
            if($title && $aims && $process && $outcome && $link){

                //if user selected an image for upload, change this and delete the previous image
                if(!empty($_FILES['file']['name'])){

                    $query = "SELECT image_path FROM project WHERE project_id = :project_id";
                    $stmt = $pdo->prepare($query);
                    $result = $stmt->execute([':project_id' => $id]);

                    //delete the old file from directory
                    if($result){
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $stmt->fetch();
                        $image_path = $row['image_path'];

                        $image = new File($image_path);
                        $image->delete_file();
                    }

                    //upload the new file
                    $image = new File($_FILES['file']);
                    $image->upload_file();
                    $file_path = $image->get_file_name();

                    //update the database
                    $query = "UPDATE project SET image_path = :image_path WHERE project_id = :project_id";
                    $stmt = $pdo->prepare($query);
                    $result = $stmt->execute([':image_path' => $file_path, ':project_id' => $id]);

                }


                $query = "UPDATE project SET title = :title, aims = :aims, process = :process, outcome = :outcome, link = :link WHERE project_id = :project_id";
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute([ ':title' => $_POST['title'], ':aims' => $_POST['aims'], ':process' => $_POST['process'], ':outcome' => $_POST['outcome'], ':link' => $_POST['link'], ':project_id' => $id ]);

                //redirect user to project page if successfully updated
                if($result){
                    $_SESSION['success'] = "Project successfully updated.";
                    header("location: project.php?id=$id");

                }else{//error updating database
                    throw new Exception('Sorry, something went wrong. Please try again.');
                }

            }else{
                throw new Exception('Please fill in all the fields with the correct data.');
            }


        }else{
            throw new Exception('This page does not exist.');
        }
        

    }catch(Exception $e){
        display_error_page($e);
        exit();
    }

}


?>