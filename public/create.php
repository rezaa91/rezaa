<?php
#CRUD - CREATE PROJECT/BLOG

require('../core/init.php');

//if non-admin tried to access page, redirect
if(!$logged_in){
    header('location: index.php');
    exit();
}


if($_SERVER['REQUEST_METHOD'] == "GET"){

    $page_title = "Create Post";
    include('../includes/header.inc.php');
    $type = $_GET['type']; //get type of post to create - blog or project


    //if valid type - display form
    if($type == 'blog' || $type == 'project'){

        include('../views/create.html'); //view displays relevant form

    }else{
        header('location: index.php');
        exit();
    }

    include('../includes/footer.inc.php');



}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //Handle form submission - insert data in to database
    
    $type = $_GET['type']; //get type of post to store - blog or project

    try{

        if($type == 'blog'){
            //validate blog data inputted by admin
            $validate = new Validate();
            $title = $validate->isStr($_POST['title']);
            $body = $validate->isStr($_POST['body']);

            //insert data in to database if inputted information is valid
            if($title && $body){
                $query = "INSERT INTO blog(admin_id, title, body, image_path, created_at) VALUES(:admin_id, :title, :body, 'sample.jpg', NOW())";
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute( [':admin_id' => $_SESSION['user']->get_id(), ':title' => $_POST['title'], ':body' => $_POST['body'] ] );

                if($result){
                    //redirect user to newly created blog if successfully created
                    $_SESSION['success'] = "Blog successfully created.";
                    $last_id = $pdo->lastInsertId();
                    header("location: blogpost.php?id=$last_id");

                }else{ //throw error if error storing data
                    throw new Exception('Sorry, something went wrong.');
                }

            }else{ //if form data failed form validation, throw error
                throw new Exception('Invalid data passed to form.');
            }



        }elseif($type == 'project'){
            //validate project data inputted by admin - same as above but for project table
            $validate = new Validate();
            $title = $validate->isStr($_POST['title']);
            $aims = $validate->isStr($_POST['aims']);
            $process = $validate->isStr($_POST['process']);
            $outcome = $validate->isStr($_POST['outcome']);
            $link = $validate->isStr($_POST['link']);

            if($title && $aims && $process && $outcome && $link){
                $query = "INSERT INTO project(image_path, title, aims, process, outcome, link, upload_date) VALUES('sample.jpg', :title, :aims, :process, :outcome, :link, NOW())";
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute([ ':title' => $_POST['title'], ':aims' => $_POST['aims'], ':process' => $_POST['process'], ':outcome' => $_POST['outcome'], ':link' => $_POST['link'] ]);

                if($result){
                    $_SESSION['success'] = "Project successfully created.";
                    $last_id = $pdo->lastInsertId();
                    header("location: project.php?id=$last_id");

                }else{//if error inserting data to database
                    throw new Exception('Sorry, something went wrong.');
                }

            }else{ //if failed form validation
                throw new Exception('Invalid data passed to form.');
            }
             
            

        }else{ //security - redirect user to homepage if type not specified
            header('location: index.php');
        }


    }catch(Exception $e){
        display_error_page($e);
    }


}






?>