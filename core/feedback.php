<?php

#This script returns feedback on CRUD activities
## e.g. 'Blog deleted successfully'

if(isset($_SESSION['success'])){
    $feedback_msg = $_SESSION['success'];

    //destroy independant sessions after displaying message
    unset($_SESSION['success']);
}



if(isset($_SESSION['failure'])){
    $feedback_msg = $_SESSION['failure'];

    //destroy independant sessions after displaying message
    unset($_SESSION['failure']);
}

?>