<?php

/**
 * This script shows the individual tutorial pages
 * i.e. html/css and JavaScript
 * It then displays the relevent view to the user using the variable 'type' from the url
 */

 require '../core/init.php';

 if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //get type of tutorial the user is trying to view
    $available_types = ['html', 'js'];
    $type = [$_GET['type']];
    
    //if the url variable type is not equal to any values in the available_types array, redirect and inform user of incorrect page
    $check = array_intersect($available_types, $type);
    if(!$check){
        $_SESSION['failure'] = "The page you are looking for does not exist";
        header('location: tutorials.php');
        exit();
    }

    //change type in to a string (from array)
    $type = implode($type);


    //videos
    $videos = [
        'html' => [
            'Getting Started' => 'https://www.youtube.com/embed/5sUIdLyklv0',
            'HTML Structure' => 'https://www.youtube.com/embed/ItYSvmpsf70',
            'The Head Tag' => 'https://www.youtube.com/embed/juT8__x-UV4',
            'The Body Tag' => 'https://www.youtube.com/embed/TCqc9-LKuxM',
            'Introducing CSS' => 'https://www.youtube.com/embed/9euazf4V23k',
            'Classes & IDs' => 'https://www.youtube.com/embed/sB0ZHWlgwIc',
            'The Div Tag' => 'https://www.youtube.com/embed/7g9NvuWX_e0',
            'Padding & Margin' => 'https://www.youtube.com/embed/ApOuizbqc2Y',
            'CSS Display Property' => 'https://www.youtube.com/embed/NdmZmQBLlmo',
            'Positioning Elements' => 'https://www.youtube.com/embed/hyuiw_tmU4U',
            'HTML Tables' => 'https://www.youtube.com/embed/5e8IBbFnNFA',
            'HTML Forms' => 'https://www.youtube.com/embed/4g6kPH6hDqg',
            'Useful HTML Tags' => 'https://www.youtube.com/embed/AWffdB4OPmE',
            'Useful CSS Properties' => 'https://www.youtube.com/embed/MfMwuN9qmpg'
        ],

        'js' => [

        ]
    ];


    //display correct page depending on type
    $page_title = $type . ' tutorials';
    include('../includes/header.inc.php');
    include('../views/tutorial_template.html');
    include('../includes/footer.inc.php');

    


 }else{
     header('location: index.php');
     exit();
 }


?>