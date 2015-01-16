<?php

// Подключаем классы ядра нашего приложения
require_once 'core/Auth.class.php';
require_once 'core/Config.class.php';
require_once 'core/DB.class.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';

Route::start(); // запускаем маршрутизатор
