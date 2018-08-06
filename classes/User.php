<?php

//administrator classes

class User{
    protected $admin_id = null;
    protected $first_name = null;
    protected $last_name = null;
    protected $username = null;
    protected $email = null;
    protected $pass = null;
    protected $reg_date = null;

    //class getters
    function get_id(){
        return $this->admin_id;
    }

    function get_full_name(){
        return $this->first_name . ' ' .$this->last_name;
    }

    function get_email(){
        return $this->email;
    }

    function get_username(){
        return $this->username;
    }

    function get_reg_date(){
        return $this->reg_date;
    }
    
}



?>