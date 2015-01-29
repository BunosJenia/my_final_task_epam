<?php

class Model
{
    public $db_connection = false;

    //
    public function __construct(){
        $this->db_connection = DB::getInstance();
    }

}