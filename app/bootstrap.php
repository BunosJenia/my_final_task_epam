<?php

// Подключаем классы ядра нашего приложения
require_once 'core/auth.php';
require_once 'core/config.php';
require_once 'core/DB.class.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once 'core/check.php';

//var_dump($_COOKIE['long_auth']);
//var_dump(Auth::getInstance()->getUser());
//var_dump($_SESSION['logged_user']);die;


// Проверяем сессии и куки для авторизации
if(isset($_SESSION['logged_user'])){
    Auth::getInstance()->setUser($_SESSION['logged_user']);
}
else{
    if(isset($_COOKIE['long_auth']) && $_COOKIE['long_auth'] !== '---'){
        $auth = Auth::getInstance();
        if($auth->processLoginByCookie() && $auth->getUser()){
            $_SESSION['logged_user'] = $auth->getUser();
        }
    }
}



// запускаем маршрутизатор
Route::start();
