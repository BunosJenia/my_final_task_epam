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

// Проверяем сессии и куки для авторизации
if(isset($_COOKIE['long_auth'])){
    $auth = Auth::getInstance();
    $auth->processLoginByCookie();
    if($auth->getUser()){
        $_SESSION['logged_user'] = &$auth->getUser();
    }
}

if(isset($_SESSION['logged_user'])){
    Auth::getInstance()->setUser($_SESSION['logged_user']);
}

if(isset($_GET['logout']) && $_GET['logout'] == 'go'){
    Auth::getInstance()->processLogout();
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
    die();
}

// запускаем маршрутизатор
Route::start();
