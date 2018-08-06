<?php

//validate user input data
class Validate{

    function isEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
    }

    function isStr($str){
        if(!empty($str)){
            return htmlentities($str);
        }
    }
}

?>