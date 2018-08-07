<?php

/**
 * Handle and validate file uploads
 */

 class File{

    protected $file_name = null;
    protected $tmp_file_name = null;
    protected $file = null;
    protected $file_type = null;
    protected $dir_location = './img/uploads/';



    //set file name and check file exists as soon as instance created
    public function __construct($file){
        if(!is_array($file)){ //if it is a string, this means that the image name was passed to the instance - therefore file already exists
            $this->file_name = $file;
        }else{
            $this->file = $file; //store file array
            $this->check_exists(); //check file before handling
        }
    }



    //check file exists - if it does, set the filename to the client side name, else sample.jpg (to be used when file not specified)
    public function check_exists(){
        if(!file_exists($this->file['tmp_name']) ){
            $this->file_name = 'sample.jpg';
        }else{
            $this->tmp_file_name = $this->file['tmp_name'];
            $this->file_type = $this->file['type'];
            $this->file_name = time() . '_' . $this->file['name']; //give name a timestamp to ensure no duplicate images made in the future
        }
    }



    //get filename to use in scripts
    public function get_file_name(){
        return $this->file_name;
    }




    //upload the file to the relevent destination
    public function upload_file(){
        //return from method if file name is sample
        if($this->file_name == 'sample.jpg'){
            return;
        }

        $allowed_types = ['image/jpeg', 'image/gif', 'image/png'];
        //check file is an image
        if(!in_array($this->file_type, $allowed_types)){
            throw new Exception('File must be an image');
            exit;
        }

        //move from temp dir in to uploads folder
        move_uploaded_file($this->tmp_file_name, $this->dir_location . $this->file_name );
    }



    
    //delete file from directory - only if not sample image
    public function delete_file(){
        if($this->file_name != 'sample.jpg'){
            unlink($this->dir_location . $this->file_name);
        }
    }


 }


?>