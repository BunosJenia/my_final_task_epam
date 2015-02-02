<?php

class Controller {
    // Свойста базового контроллера
    public $model;
    public $view;
    public $params;

    // В конструкторе родителя контролера мы указываем главный template(в котором содержится header и footer, нужно только добавлять контент)
    function __construct(){
        $this->view = new View();
        $this->view->setMainTemplate($_SERVER["DOCUMENT_ROOT"].'/app/views/main_template.tpl');
    }

    function action_index(){
    }

    // Создаем метод редирект
    public function redirect($url){
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/'.$url;
        header('Location:'.$host);
    }

    public function setParams($params){
        $this->params = $params;
    }
}