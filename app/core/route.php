<?php

class Route
{
    // Статическая функция, которая по url определяет контроллер, действие и параметр и создает объект контроллера
    public static function start(){
        // Имя контроллера и действия по умолчанию
        $controller_name = 'Main';
        $action_name = 'index';

        // Разбиваем наш url по '/' и присваиваем значения controller, action, params(если они сущ-ют)
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // Имя контроллера
        if(!empty($routes[1])){
            $controller_name = $routes[1];
        }

        // Имя действия
        if(!empty($routes[2])){
            $action_name = $routes[2];
        }


        // Дописываем строки для корректного названия классов, моделей и действий
        $model_name = 'Model_'.$controller_name;
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;

        // подцепляем файл с классом модели (файла модели может и не быть)
        $model_file = strtolower($model_name).'.php';
        $model_path = "app/models/".$model_file;
        if(file_exists($model_path)){
            include "app/models/".$model_file;
        }

        // Подключаем наш контроллер
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "app/controllers/".$controller_file;
        if(file_exists($controller_path)){
            include "app/controllers/".$controller_file;
        }
        else{
            Route::ErrorPage404();
        }

        // Создаем новый объект контроллера
        $controller = new $controller_name;
        $action = $action_name;

        // Если существует 3 параметр в нашем url, то присваиваем значение параметра
        if(!empty($routes[3])){
            $controller->params = $routes[3];
        }

        if(method_exists($controller, $action)){
            $controller->$action();
        }
        else{
            Route::ErrorPage404();
        }

    }

    public static function ErrorPage404(){
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }

}