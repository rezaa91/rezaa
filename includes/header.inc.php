<!DOCTYPE html>


<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="author" content="rezaa"/>
        <meta name="keywords" content="full stack developer portfolio front end javascript php react blog digital marketting web design develop laravel tutorial html css sass"/>
        <meta name="description" content=""/>

        <title><?php echo $page_title; ?></title>

        <!--stylesheet-->
        <link rel="stylesheet" href="/rezaa/public/src/css/app.css" />
        <!--javascript file-->
        <script src="/rezaa/public/src/js/app.js"></script>

        <!--fonts-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Slab" rel="stylesheet">


    </head>
    <body>
        
        <div id="page-wrapper">

        <?php
            include('navigation.inc.html'); //include navigation

            include('../core/feedback.php'); //require success/failure sessions
            if(isset($feedback_msg)){
                echo '<div class="feedback-modal">
                        <div class="feedback-close"><div class="close text-right"><a class="close_btn">x</a></div></div>
                        <div class="feedback-content">'
                            . $feedback_msg .
                        '</div>
                    </div>';
            }
        ?>


        