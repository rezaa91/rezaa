<!DOCTYPE html>


<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="author" content="Rezaa"/>
        <meta name="keywords" content="web developer hull, full stack developer, php, javascript, computer programming, tutorials, rezaa tutorials, front end development, yorkshire, user interface, learn to code, blogger, vlogger, developer portfolio"/>
        <meta name="description" content="Want to learn how to code? Follow my HTML &amp; CSS tutorials and JavaScript tutorials to learn how. Want to keep up with the industry? Follow my blogs for helpful tips &amp; tricks, my view on all things web amongst other web-related topics. Also, you can view my portfolio to have a look at some of the recent projects I have created/contributed to."/>

        <title><?php echo $page_title; ?></title>

        <!--stylesheet-->
        <link rel="stylesheet" href="/src/css/app.css" />
        <!--javascript file-->
        <script src="/src/js/app.js"></script>

        <!--fonts-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Slab" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous"> <!--font awesome-->


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


        