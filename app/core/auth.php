<?php

class Auth
{
    private static $instance = null;
    private $user_id = false;

    // Реализуем паттерн одиночка
    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new Auth();
        }
        return self::$instance;
    }

    // Метод который вызываем при выходе.
    public function processLogout(){
        unset($_SESSION['logged_user']);
        setcookie('long_auth', '---', -1);
    }

    // Сеттер и геттер для св-ва идентификатора пользователя
    public function setUser($user_id){
        $this->user_id = $user_id;
    }
    public function getUser(){
        return $this->user_id;
    }

    // Метод, в котором проверяем на длительную авторизацию и возвращаем св-во user_id
    public function processLoginByCookie(){
        $r = DB::getInstance()->executeQuery("SELECT `u_id`
                                                    FROM `users`
                                                    WHERE `u_long_auth`=:cookie;",
            array(array(':cookie', $_COOKIE['long_auth'])));
        if($r["rows"] === 1){
            $this->user_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_id"];
            return $this->user_id;
        }
        else{
            return false;
        }
    }

    // Метод в котором проверяем есть ли пользователь с таким логином и паролем, если есть, то возвращаем св-во user_id
    public function getAuthResult($login, $password){
        $r = DB::getInstance()->executeQuery("SELECT `u_id`
                                                    FROM `users`
                                                    WHERE `u_login`=:login AND `u_password`=:password;",
                                                array(array(':login', $login), array(':password', sha1($password))));
        if($r["rows"] === 1){
            $this->user_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_id"];
            return $this->user_id;
        }
        else{
            return false;
        }
    }

    public function registration($login, $password, $email){
        $r = DB::getInstance()->executeQuery("INSERT INTO `users`(`u_login`, `u_password`, `u_email`)
                                                      VALUES (:login, :password, :email);",
            array(array(':login', $login), array(':password', sha1($password)), array(':email', $email)));
        if($r["rows"] === 1){
            $this->user_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_id"];
            return true;
        }
        else{
            return false;
        }
    }

    private function __construct(){
    }
    private function __clone(){
    }
    private function __wakeup(){
    }
    public function __destruct(){
    }
}