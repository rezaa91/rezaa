<?php

#This class has the same variables as the blog table columns
#It is used in order to use OOP code inside the application

class Blog{
    protected $blog_id = null;
    protected $admin_id = null;
    protected $title = null;
    protected $body = null;
    protected $image_path = null;
    protected $created_at = null;
    protected $updated_at = null;

    //getter methods
    function get_blog_id(){
        return $this->blog_id;
    }

    function get_admin_id(){
        return $this->admin_id;
    }

    function get_title(){
        return $this->title;
    }

    function get_body(){
        return $this->body;
    }

    function get_image_path(){
        return $this->image_path;
    }

    function get_created_at(){
        return $this->created_at;
    }

    function get_updated_at(){
        return $this->updated_at;
    }

    //other methods
    //return preview of blog
    function blog_preview(){
        $body = $this->body; //get the blog content
        $body = substr($body, 0, 70); //only allow set amount of characters before returning
        return $body . '...';
    }

}


?>