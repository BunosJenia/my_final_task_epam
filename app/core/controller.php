<?php

class Controller {

    public $model;
    public $view;


    function __construct(){
        $this->view = new View();
        $this->view->setMainTemplate($_SERVER["DOCUMENT_ROOT"].'/app/views/main_template.tpl');
    }

    function action_index(){
    }
}